This is the Order Flow for placing Magento Order using razorpay with graphql
1. set Payment Method on Cart
```
mutation {
  setPaymentMethodOnCart(input: {
      cart_id: "F8MruNi2R7tiZqo8Pkglxaz370VrUnCu"
      payment_method: {
          code: "razorpay"
      }
  }) {
    cart {
      selected_payment_method {
        code
      }
    }
  }
}
```
2. Create Razorpay Order against the cart total(just after the final placeorder button click)
```
mutation {
  createRazorpayOrder (
    cart_id: "F8MruNi2R7tiZqo8Pkglxaz370VrUnCu"
  ){
    success
    rzp_order
    order_id
    amount
    message
  }
}
```
3. Generate Payment from the Frontend/React/using razorpay's checkout.js & obtain razorpay_payment_id & razorpay_signature

4. Save Razorpay Response Details against Cart after payment success
```
mutation {
  setRzpPaymentDetailsOnCart (
    input: {
      cart_id: "F8MruNi2R7tiZqo8Pkglxaz370VrUnCu"
      rzp_payment_id: "pay_GmVq2o9VzEQkPL"
      rzp_order_id: "order_GmVovQtWtOsquw"
      rzp_signature: "c95c961f7f4682e932f8dfc7d52e87c5f0dff43bce81efa86ad80a7c808983b7"
    }
  ){
  cart{
    id
  }
  }
}
```
5. Finally Place Magento Order
```
mutation {
  placeOrder(input: {cart_id: "F8MruNi2R7tiZqo8Pkglxaz370VrUnCu"}) {
    order {
      order_number
    }
  }
}
```
## Razorpay Payment Extension for Magento

This extension utilizes Razorpay API and provides seamless integration with Magento, allowing payments for Indian merchants via Credit Cards, Debit Cards, Net Banking, Wallets and EMI without redirecting away from the magento site.

### Installation

Install the extension through composer package manager.

```
composer require razorpay/magento
bin/magento module:enable Razorpay_Magento
```

### Install through "code.zip" file

Extract the attached code.zip from release

Go to "app" folder

Overwrite content of "code" folder with step one "code" folder (Note: if code folder not exist just place the code folder from step-1).

Run from magento root folder.

```
bin/magento module:enable Razorpay_Magento
bin/magento setup:upgrade
```

You can check if the module has been installed using `bin/magento module:status`

You should be able to see `Razorpay_Magento` in the module list


Go to `Admin -> Stores -> Configuration -> Payment Method -> Razorpay` to configure Razorpay


If you do not see Razorpay in your gateway list, please clear your Magento Cache from your admin
panel (System -> Cache Management).

### Note: Don't mix composer and zip install.

### Support

Visit [https://razorpay.com](https://razorpay.com) for support requests or email contact@razorpay.com.
