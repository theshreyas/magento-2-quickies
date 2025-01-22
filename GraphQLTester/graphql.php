<?php
require __DIR__ . '/../app/bootstrap.php';
require 'graphqlQueries.php';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$objectManager->get('Magento\Framework\Registry')->register('isSecureArea', true);
$objectManager->get('Magento\Framework\App\State')->setAreaCode('frontend');
$store = $objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore();
$currencySymbol = $store->getBaseCurrency()->getCurrencySymbol();

$last10customers = $objectManager->create('\Magento\Customer\Model\ResourceModel\Customer\CollectionFactory')->create()->setOrder('entity_id', 'DESC')->setPageSize(10);

if ($_POST) {
    $cartId = $_COOKIE['cartId'] ?? false;
    $customerToken = $_COOKIE['customerToken'] ?? false;
    $variables = ["cartId" => $cartId];
    $headers = $customerToken ? ['Authorization: Bearer ' . $customerToken] : [];
    switch ($_POST['action']) {
    case 'customerFlow':
        if (isset($_POST['c_email'])) {
            $variables = [
                "fname" => $_POST['fname'], "lname" => $_POST['lname'],
                "email" => $_POST['c_email'], "password" => $_POST['password'],
            ];
            $result = curlCall($createCustomer, $variables);
            $decoded = json_decode($result, true);
            if ($decoded['data']['createCustomer']['customer'] ?? false) {
                $response = createCustToken($_POST['c_email']);
            }
        } else {
            $response = createCustToken($_POST['email']);
            $result = json_encode($response);
        }
        break;
    case 'guestCartCreate':
        $result = curlCall($createGuestCart);

        $decoded = json_decode($result, true);
        $cartId = $decoded['data']['createGuestCart']['cart']['id'] ?? false;
        $quoteId = $objectManager->get('\Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface')->execute($cartId);
        $decoded['quoteIdCustom'] = $quoteId;
        $result = json_encode($decoded);
        setcookie('cartId', $cartId, time() + (86400 * 1), "/"); // 86400 = 1 day
        setcookie('customerToken', false, time() + (86400 * 1), "/");
        break;
    case 'customerCart':
        $result = curlCall($createCustomerCart, [], $headers);
        $decoded = json_decode($result, true);
        $cartId = $decoded['data']['customerCart']['id'] ?? false;
        $quoteId = $objectManager->get('\Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface')->execute($cartId);
        $decoded['quoteIdCustom'] = $quoteId;
        $result = json_encode($decoded);
        setcookie('cartId', $cartId, time() + (86400 * 1), "/");
        break;
    case 'add-product':
        $variables['sku'] = $_POST['sku'] ?? $simpleProductSkuTest;
        $result = curlCall($addSimpleProduct, $variables, $headers);
        break;
    case 'add-shipping-address':
        $result = curlCall($addShippingAddress, $variables, $headers);
        break;
    case 'add-exist-shipping-address':
        $variables['addrId'] = (int) $_POST['addrId'];
        $result = curlCall($addExtShippingAddress, $variables, $headers);
        break;
    case 'add-exist-billing-address':
        $variables['addrId'] = (int) $_POST['addrId'];
        $result = curlCall($addExtBillingAddress, $variables, $headers);
        break;
    case 'add-billing-address':
        $result = curlCall($addBillingAddress, $variables, $headers);
        break;
    case 'copy-shipping-address':
        $result = curlCall($addBillingAddressSameAsShipping, $variables, $headers);
        break;
    case 'add-shipping-method':
        $codes = preg_split('/-(?=)/', $_POST['shipment']);
        $variables['carrierCode'] = $codes[0];
        $variables['methodCode'] = $codes[1];
        $result = curlCall($addShippingMethod, $variables, $headers);
        break;

    case 'set-guest-email':
        $variables['email'] = $_POST['email'];
        $result = curlCall($setGuestEmail, $variables);
        break;

    case 'add-payment-method':
        $variables['payment'] = $_POST['payment'];
        $result = curlCall($setPaymentMethod, $variables, $headers);
        break;

    case 'place-order':
        $result = curlCall($placeOrder, $variables, $headers);
        break;

    case 'fetchCustomer':
        $customer = $objectManager->get('\Magento\Customer\Model\CustomerFactory')->create()->setWebsiteId((int) $store->getWebsiteId())->loadByEmail($_POST['email']);
        $data = $customer->getData();
        foreach ($customer->getAddresses() as $key => $value) {
            $data['addresses'][$key] = $value->getData();
        }
        $result = json_encode($data, true);
        break;

    default:
        $result = "Invalid Action";
        break;
    }
    echo $result;
    die;
}
function createCustToken($email) {
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $store = $objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore();
    $response = $objectManager->get('Magento\LoginAsCustomerGraphQl\Model\LoginAsCustomer\CreateCustomerToken')->execute($email, $store);
    $response['email'] = $email;
    if (isset($response['customer_token'])) {
        setcookie('customerToken', $response['customer_token'], time() + (86400 * 1), "/");
    }
    return $response;
}
function curlCall($query, $variables = [], $headers = []) {
    global $graphqlEndpoint;
    $headers[] = 'Content-Type: application/json';
    $query = json_encode(['query' => $query, 'variables' => $variables], JSON_THROW_ON_ERROR);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graphqlEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magento GraphQl Order Flow Tester</title>
    <style>.container,.side-container{padding:20px;border-radius:10px}body{font-family:Arial,sans-serif;background-color:#f0f0f0;margin:0;padding:0;display:flex;justify-content:center;align-items:center;height:100vh}.container{width:300px;text-align:center;margin:20px}.side-container{background-color:#fff;box-shadow:0 0 10px rgba(0,0,0,.1);width:600px;overflow-y:auto;height:780px}#search-product,.action-button{background-color:#007bff;color:#fff;padding:10px;cursor:pointer;transition:background-color .3s}b.green{color:green}b.red{color:red}h1{font-size:24px;margin-bottom:20px}.button-container{display:flex;flex-direction:column;gap:10px}.formInput{width:97%;height:25px;font-size:medium;margin-bottom:12px}#input,#output,.action-button{font-size:16px}.button-container>div{display:none}#customerFlow{display:none;position:relative}#search-product{font-size:16px;width:35%;height:35px;border-radius:5px;border:none}.action-button{border:none;width:100%;border-radius:5px}.action-button.disabled{background-color:#a9a9a9;pointer-events:none}#input{margin-top:19px;overflow:auto}#output{margin-top:20px;color:#333;text-align:left;overflow:auto}.radio-container{display:flex;justify-content:center;gap:20px;font-size:larger;margin-bottom:20px}.button-container .form { display: none; input[type=text],input[type=email],select, textarea {width: 100%;padding: 12px;font-size: 17px;border: 1px solid #ccc;border-radius: 4px;box-sizing: border-box;margin-top: 6px;margin-bottom: 16px;resize: vertical;}}table td,table th{border:1px solid #ddd;padding:8px;text-align:right}table th{background-color:#f2f2f2}.summary{width:50%;margin:20px 0;font-size:16px}.summary div{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #ddd}.summary div:last-child{border-bottom:none}.summary .label{font-weight:700}.summary .value{font-weight:400}.summary .grand-total{font-size:16px;color:#d9534f;font-weight:700}.dropd{margin-top:14px;height:27px}.spinner{display:none;position:absolute;left:20%;top:16%;border:4px solid rgba(255,255,255,.3);border-radius:50%;border-top:4px solid #fff;width:16px;height:16px;animation:1s linear infinite spin;margin-right:10px}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}</style>
</head>
<body>
    <div class="side-container"><div id="input"></div></div>
    <div class="container">
        <h1 style="top: 15%;width: inherit;">Magento GraphQl Order Flow Tester</h1>
        <div class="radio-container" id="customerTypeSelector">
            <label>
                <input type="radio" name="userType" value="guest" id="guest" data-type="guestFlow">
                Guest
            </label>
            <label>
                <input type="radio" name="userType" value="customer" id="customer" data-type="customerFlow">
                Customer
            </label>
        </div>
        <div class="button-container" id="button-container">
            <div>
              <div class="radio-container">
                  <label>
                      <input type="radio" name="customerFlow" id="createCustomerRadio" value="new" data-type="createCustomer">
                      Create New Customer
                  </label>
                  <label>
                      <input type="radio" name="customerFlow" value="old" data-type="existingCustomer">
                      Existing Customer Login
                  </label>
              </div>
              <div class="form">
                <form id="createCustomer">
                  <input type="text" id="fname" name="firstname" placeholder="First name..">
                  <input type="text" id="lname" name="lastname" placeholder="Last name..">
                  <input type="email" id="c_email" name="c_email" placeholder="Email..">
                  <input type="text" id="password" name="password" placeholder="Password">
                  <button class="formInput" type="button" id="randomCustomer" style="width: 55%;" onclick="randomcustomer();return false;">🔀 AutoFill</button>
                </form>
              </div>
              <div class="form">
                <form id="existingCustomer">
                  <select name="e_email" id="e_email" class="formInput" style="height: 45px;">
                    <?php foreach ($last10customers as $c) {?>
                      <option value="<?=$c->getEmail();?>"><?=$c->getFirstname() . " " . $c->getMiddlename() . " " . $c->getLastname() . " " . $c->getEmail();?></option>
                    <?php }?>
                  </select>
                  <p style="float: right;font-size: 10px;margin-top: -3px;">Last 10 Customers Only</p>
                </form>
              </div>
              <button class="action-button" id="customerFlow">
                <span class="spinner" id="spinner"></span>Customer Login
              </button>
            </div>
            <div>
              <button class="action-button" id="customerCart">Create Customer Cart</button>
            </div>
            <div>
              <button class="action-button" id="guestFlow">Create Guest Cart</button>
            </div>
            <div>
              <button class="action-button" id="add-product">Add Product</button>
              <p>OR</p>
              <input type="text" id="sku" class="formInput" style="font-size: 16px;width: 60%;" placeholder="Product SKU">
              <button id="search-product" class="action-button">Add</button>
            </div>
            <div>
              <button class="action-button" id="add-shipping-address">Add Shipping Address</button>
                <p class="customerOnly">OR</p>
                <select name="shippingAddress" class="formInput customerOnly" id="shippingAddress">
                </select>
                <button class="action-button customerOnly" id="add-exist-shipping-address">Select Shipping Address</button>
            </div>
            <div>
              <button class="action-button" id="add-billing-address">Add Billing Address</button>
                <p class="customerOnly">OR</p>
                <select name="billingAddress" id="billingAddress" class="formInput customerOnly">
                </select>
                <button id="add-exist-billing-address" class="action-button customerOnly">Select Billing Address</button>
                <p>OR</p>
                <button class="action-button" id="copy-shipping-address">Same as Shipping Address</button>
            </div>
            <div>
              <button class="action-button" id="add-shipping-method">Add Shipping Method</button>
              <select name="shippingmethod" id="shippingmethod" class="formInput dropd">
              </select>
            </div>
            <div>
              <input type="email" id="guest-email" class="formInput" placeholder="Enter Guest email">
              <button class="formInput" id="randomEmail" style="width: 55%;" onclick="randomEmail()">🔀 AutoFill</button>
              <button class="action-button" id="set-guest-email">Set Guest Email on Cart</button>
            </div>
            <div>
              <button class="action-button" id="add-payment-method">Add Payment Method</button>
              <select name="paymentmethod" id="paymentmethod" class="formInput dropd">
              </select>
            </div>
            <div>
              <button class="action-button" id="place-order">Place Order</button>
            </div>
            <div>
              <button class="action-button" id="place-another">Place Another Order</button>
            </div>
        </div>
    </div>
    <div class="side-container"><div id="output"></div></div>
    <script>
        const Id = document.getElementById.bind(document);

        function randomcustomer() {
            var chars = 'abcdefghijklmnopqrstuvwxyz';
            let email = chars[Math.floor(Math.random() * 26)] + Math.random().toString(36).substring(2, 11) + '@mailinator.com';
            Id('fname').value = 'FirstTest-' + Math.floor(Math.random() * (9999 - 1111 + 1));
            Id('lname').value = 'LastTest-' + Math.floor(Math.random() * (9999 - 1111 + 1));
            Id('c_email').value = email;
            Id('password').value = 'Pa$$w0rd!';
        }

        function randomEmail() {
            var chars = 'abcdefghijklmnopqrstuvwxyz';
            let email = chars[Math.floor(Math.random() * 26)] + Math.random().toString(36).substring(2, 11) + '@mailinator.com';
            Id('guest-email').value = email;
        }
        document.addEventListener('DOMContentLoaded', () => {
            const Id = document.getElementById.bind(document);
            let radios = document.querySelectorAll('input[type="radio"]');
            let emailInput = Id('email');
            let buttonContainer = Id('button-container');
            let buttons = document.querySelectorAll('.action-button');
            let output = Id('output');
            let input = Id('input');

            radios.forEach(radio => {
                radio.addEventListener('change', () => { //display respective formfields
                    let type = radio.getAttribute('data-type');
                    let types = ['guestFlow', 'customerFlow'];
                    let cType = ['createCustomer', 'existingCustomer'];
                    if (types.find(e => e === type)) { //guest/customer selection
                        var otherType = types[1 - types.indexOf(type)]
                        Id('customerTypeSelector').style.display = 'none';
                        var custSpecificFields = document.getElementsByClassName('customerOnly');
                        for (var i = 0; i < custSpecificFields.length; i++) {
                            custSpecificFields[i].style.display = type == 'guestFlow' ? 'none' : 'block';
                        }
                    } else { //existing/newcustomer selection
                        var otherType = cType[1 - cType.indexOf(type)]
                        Id('customerFlow').style.display = 'block';
                    }
                    Id(type).parentElement.style.display = 'block';
                    Id(otherType).parentElement.style.display = 'none';
                });
            });

            buttons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const toggleButton = () => e.target.classList.toggle("disabled");
                    toggleButton();

                    let action = button.id;
                    let params = {};

                    switch (action) {
                        case 'customerFlow':
                            Id('spinner').style.display = 'block';
                            params = Id("createCustomerRadio").checked ?
                                {
                                    fname: Id('fname').value,
                                    lname: Id('lname').value,
                                    c_email: Id('c_email').value,
                                    password: Id('password').value,
                                } :
                                {
                                    email: Id('e_email').value
                                };
                            break;

                        case 'search-product':
                            const sku = Id('sku').value.trim();
                            if (!sku) {
                                alert('Please Enter Sku');
                                toggleButton();
                                e.nativeEvent.stopImmediatePropagation();
                                return;
                            }
                            params = {
                                sku
                            };
                            action = 'add-product';
                            break;

                        case 'add-exist-shipping-address':
                            params = {
                                addrId: Id('shippingAddress').value
                            };
                            break;

                        case 'add-exist-billing-address':
                            params = {
                                addrId: Id('billingAddress').value
                            };
                            break;

                        case 'guestFlow':
                            action = 'guestCartCreate';
                            break;

                        case 'set-guest-email':
                            const email = Id('guest-email').value;
                            if (!email) {
                                alert('Please Enter Email');
                                toggleButton();
                                e.nativeEvent.stopImmediatePropagation();
                                return;
                            }
                            params = {
                                email
                            };
                            break;

                        case 'add-shipping-method':
                            const shipMethod = Id('shippingmethod').value;
                            if (!shipMethod) {
                                alert('Please Enter shipment Method');
                                toggleButton();
                                e.nativeEvent.stopImmediatePropagation();
                                return;
                            }
                            params = {
                                shipment: shipMethod
                            };
                            break;

                        case 'add-payment-method':
                            const paymentVal = Id('paymentmethod').value;
                            if (!paymentVal) {
                                alert('Please Enter Payment Method');
                                toggleButton();
                                e.nativeEvent.stopImmediatePropagation();
                                return;
                            }
                            params = {
                                payment: paymentVal
                            };
                            break;

                        case 'place-another':
                            output.innerHTML = '';
                            input.innerHTML = '';
                            Id('customerTypeSelector').style.display = 'block';
                            document.getElementsByName("userType").forEach(radio => radio.checked = false);
                            button.parentElement.style.display = 'none';
                            toggleButton();
                            return;

                        default:
                            break;
                    }

                    hitGraphQlApi(action, button, params);
                });
            });

            function hitGraphQlApi(action, button, extraparams = {}) {
                let params = {
                    action,
                    ...extraparams
                };
                let startTime = Date.now();
                fetch('graphql.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams(params)
                })
                .then(response => response.text())
                .then(data => {
                    processResponse(action, data, Date.now() - startTime, button);
                    if (action === 'customerFlow')
                        Id('spinner').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    output.innerHTML += `<p>${action}: Error performing action. Reason : ${error}</p>`;
                });
            }

            function processResponse(action, data, timeTaken, button) {
                const sym = '<?=$currencySymbol?>';
                const parsedData = JSON.parse(data);
                const responseData = parsedData.data || {};
                const {
                    createGuestCart,
                    customerCart,
                    addProductsToCart,
                    placeOrder,
                    setShippingMethodsOnCart,
                    setShippingAddressesOnCart,
                    setGuestEmailOnCart,
                    createCustomer
                } = responseData;

                const cartId = createGuestCart?.cart?.id || customerCart?.id;
                const cartItems = addProductsToCart?.cart?.itemsV2?.items;
                const quoteId = parsedData?.quoteIdCustom;
                const email = createCustomer?.customer?.email || parsedData?.email;
                const incrementId = placeOrder?.orderV2?.number;
                const orderId = placeOrder?.orderV2?.id;
                const className = parsedData.errors || placeOrder?.errors?.length || addProductsToCart?.user_errors?.length ? "red" : "green";
                const paymentMethods = setShippingMethodsOnCart?.cart?.available_payment_methods;
                const selectedShipping = setShippingMethodsOnCart?.cart?.shipping_addresses[0]?.selected_shipping_method;
                const shippingMethods = setShippingAddressesOnCart?.cart?.shipping_addresses[0]?.available_shipping_methods;
                const guestEmail = setGuestEmailOnCart?.cart?.email;

                if (selectedShipping) {
                    Id('grandtotal').textContent = sym + setShippingMethodsOnCart.cart.prices?.grand_total?.value;
                    Id('shipping').textContent = sym + selectedShipping.amount?.value;
                    Id('shipping').parentElement.style.display = 'flex';
                }

                if (shippingMethods) {
                    const shippingMethod = Id('shippingmethod');
                    shippingMethod.options.length = 0;
                    shippingMethods.forEach(item => {
                        const option = new Option(
                            `${item.carrier_title} - ${item.method_title} ${sym}${item.amount?.value}`,
                            `${item.carrier_code}-${item.method_code}`
                        );
                        shippingMethod.add(option);
                    });
                }

                if (paymentMethods) {
                    const selPayment = Id('paymentmethod');
                    selPayment.options.length = 0;
                    paymentMethods.forEach(item => {
                        selPayment.add(new Option(item.title, item.code));
                    });
                }

                if (cartItems?.length) {
                    const prices = addProductsToCart.cart.prices;
                    let items = '';
                    cartItems.forEach(item => {
                        const { sku } = item.product;
                        const quantity = item.quantity;
                        const price = sym + item.product.price_range.minimum_price.final_price.value;
                        const rowTotal = sym + (quantity * item.product.price_range.minimum_price.final_price.value);
                        items += `<tr><td>${sku}</td><td>${quantity}</td><td>${price}</td><td>${rowTotal}</td></tr>`;
                    });
                    input.innerHTML += `
                    <div>
                        <b>Cart Items</b>:
                        <table>
                            <thead><tr><th>SKU</th><th>Quantity</th><th>Price</th><th>Row Total</th></tr></thead>
                            <tbody>${items}</tbody>
                        </table>
                        <div class="summary">
                            <div><span class="label">Subtotal:</span><span class="value" id="subtotal">${sym}${prices?.subtotal_excluding_tax?.value}</span></div>
                            <div style="display:none;"><span class="label">Shipping Charges:</span><span class="value" id="shipping"></span></div>
                            <div><span class="label">Grand Total:</span><span class="value grand-total" id="grandtotal">${sym}${prices?.grand_total?.value}</span></div>
                        </div>
                    </div>`;
                }

                const outputEntries = [
                    cartId && `<p><b>Quote Masked Id</b>: ${cartId}</p>`,
                    quoteId && `<p><b>Quote Id</b>: ${quoteId}</p>`,
                    guestEmail && `<p><b>Guest Email</b>: ${guestEmail}</p>`,
                    incrementId && `<p><b>Increment Id</b>: ${incrementId} <b>Order Id</b>: ${atob(orderId)}</p>`,
                    email && `<p><b>Customer Email</b>: ${email}</p>`
                ].filter(Boolean).join('');

                input.innerHTML += outputEntries;

                output.innerHTML += `<p><b class="${className}">${action}</b>: ${data} <span style="float:right;font-size:14px;">${timeTaken}ms</span></p>`;

                if (className !== 'red') {
                    button.parentElement.style.display = 'none';
                    let nextButton = button.parentElement.nextElementSibling;
                    if (nextButton) {
                        if ((button.id === 'add-shipping-method' || button.id === 'customerCart') && !Id("guest").checked) {
                            nextButton = nextButton.nextElementSibling;
                        }
                        nextButton.style.display = 'inline-block';
                    }
                }

                button.classList.toggle("disabled");

                if (email) {
                    displayCustomerDetails(email);
                }
            }

            function displayCustomerDetails(email) {
                fetch('graphql.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'fetchCustomer',
                        email: email
                    })
                })
                .then(response => response.text())
                .then(data => {
                    let parsedData = JSON.parse(data);
                    let addr = parsedData.addresses;
                    let shippingAddress = Id('shippingAddress');
                    let billingAddress = Id('billingAddress');
                    shippingAddress.options.length = 0;
                    billingAddress.options.length = 0;
                    if (!addr) {
                        Id("add-exist-billing-address").classList.add("disabled");
                        Id("add-exist-shipping-address").classList.add("disabled");
                        var noOption = document.createElement("option");
                        noOption.text = "No Saved Addresses";
                        noOption.value = 0;
                        shippingAddress.add(noOption);
                        billingAddress.add(noOption.cloneNode(true));
                    } else {
                        Id("add-exist-billing-address").classList.remove("disabled");
                        Id("add-exist-shipping-address").classList.remove("disabled");
                    }
                    for (var id in addr) {
                        let option = document.createElement('option');
                        option.value = id;
                        option.text = addr[id].street + ' ' + addr[id].city + ' ' + addr[id].region + ' ' + addr[id].country_id;
                        billingAddress.appendChild(option.cloneNode(true));
                        shippingAddress.appendChild(option);
                    }
                    input.innerHTML += `<p><b>Name</b>: ${parsedData.firstname} ${parsedData.lastname}</p>`;
                    input.innerHTML += `<p><b>Customer Id</b>: ${parsedData.entity_id} \t <b>Group Id</b>: ${parsedData.group_id}</p>`;
                })
            }
        });
        </script>
    </body>
</html>