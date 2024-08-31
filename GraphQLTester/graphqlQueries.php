<?php
$graphqlEndpoint = 'http://m3.test/graphql';
$simpleProductSkuTest = '24-MB01';

$createCustomer = <<<'GRAPHQL'
mutation ($fname: String!, $lname: String!, $email: String!, $password: String!) {
  createCustomer(
    input: {
      firstname: $fname
      lastname: $lname
      email: $email
      password: $password
      is_subscribed: true
    }
  ) {
    customer {
      firstname
      lastname
      email
      is_subscribed
    }
  }
}
GRAPHQL;
$createGuestCart = <<<'GRAPHQL'
mutation {
  createGuestCart {
    cart {
      id
    }
  }
}
GRAPHQL;
$createCustomerCart = <<<'GRAPHQL'
{
  customerCart{
    id
  }
}
GRAPHQL;
$addSimpleProduct = <<<'GRAPHQL'
mutation ($cartId: String!, $sku: String!)
{
  addProductsToCart(
    cartId: $cartId
    cartItems: [
      {
        quantity: 1
        sku: $sku
      }
    ]
  ) {
    cart {
        prices {
            subtotal_excluding_tax {
                value
            }
            grand_total {
                value
            }
        }
      itemsV2 {
        items {
          product {
            name
            sku
            price_range {
                minimum_price {
                    final_price {
                        value
                    }
                }
            }
          }
          quantity
        }
        total_count
        page_info {
          page_size
          current_page
          total_pages
        }
      }
    }
    user_errors {
      code
      message
    }
  }
}
GRAPHQL;
$addShippingAddress = <<<'GRAPHQL'
mutation ($cartId: String!) {
  setShippingAddressesOnCart(
    input: {
      cart_id: $cartId
      shipping_addresses: [
        {
          address: {
            firstname: "Bob"
            middlename: "Joe"
            lastname: "Roll"
            prefix: "Mr."
            suffix: "Jr."
            company: "Magento"
            street: ["Magento Pkwy", "Main Street"]
            city: "Austin"
            region: "TX"
            postcode: "78758"
            country_code: "US"
            telephone: "8675309"
            fax: "8675311"
            save_in_address_book: true
          }
        }
      ]
    }
  ) {
    cart {
      shipping_addresses {
        firstname
        middlename
        lastname
        prefix
        suffix
        company
        street
        city
        region {
          code
          label
        }
        postcode
        telephone
        fax
        country {
          code
          label
        }
        available_shipping_methods{
            carrier_code
            method_code
            carrier_title
            method_title
            amount {
                value
            }
        }
      }
    }
  }
}
GRAPHQL;
$addExtShippingAddress = <<<'GRAPHQL'
mutation ($cartId: String!,$addrId: Int!) {
  setShippingAddressesOnCart(
    input: {
      cart_id: $cartId
      shipping_addresses: {
        customer_address_id: $addrId
      }
    }
  ) {
    cart {
      shipping_addresses {
        firstname
        middlename
        lastname
        prefix
        suffix
        company
        street
        city
        region{
          code
          label
        }
        postcode
        telephone
        fax
        country{
          code
          label
        }
        available_shipping_methods{
            carrier_code
            method_code
            carrier_title
            method_title
            amount {
                value
            }
        }
      }
    }
  }
}
GRAPHQL;
$addExtBillingAddress = <<<'GRAPHQL'
mutation ($cartId: String!,$addrId: Int!) {
  setBillingAddressOnCart(
    input: {
      cart_id: $cartId
      billing_address: {
        customer_address_id: $addrId
      }
    }
  ) {
    cart {
      billing_address {
        firstname
        middlename
        lastname
        prefix
        suffix
        company
        street
        city
        region{
          code
          label
        }
        postcode
        telephone
        fax
        country{
          code
          label
        }
      }
    }
  }
}
GRAPHQL;
$addBillingAddress = <<<'GRAPHQL'
mutation ($cartId: String!) {
  setBillingAddressOnCart(
    input: {
      cart_id: $cartId
      billing_address: {
        address: {
          firstname: "Bob"
          middlename: "Joe"
          lastname: "Roll"
          prefix: "Mr."
          suffix: "Jr."
          company: "Magento"
          street: ["Magento Pkwy", "Main Street"]
          city: "Austin"
          region: "TX"
          postcode: "78758"
          country_code: "US"
          telephone: "8675309"
          fax: "8675311"
          save_in_address_book: true
        }
        same_as_shipping: false
      }
    }
  ) {
    cart {
      billing_address {
        firstname
        middlename
        lastname
        prefix
        suffix
        company
        street
        city
        region{
          code
          label
        }
        postcode
        telephone
        fax
        country{
          code
          label
        }
      }
    }
  }
}
GRAPHQL;
$addBillingAddressSameAsShipping = <<<'GRAPHQL'
mutation ($cartId: String!) {
  setBillingAddressOnCart(
    input: {
      cart_id: $cartId
      billing_address: {
        same_as_shipping: true
      }
    }
  ) {
    cart {
      billing_address {
        firstname
        middlename
        lastname
        prefix
        suffix
        company
        street
        city
        region{
          code
          label
        }
        postcode
        telephone
        fax
        country{
          code
          label
        }
      }
    }
  }
}
GRAPHQL;
$addShippingMethod = <<<'GRAPHQL'
mutation ($cartId: String!) {
  setShippingMethodsOnCart(
    input: {
      cart_id: $cartId,
      shipping_methods: [
        {
          carrier_code: "tablerate"
          method_code: "bestway"
        }
      ]
    }
  ) {
    cart {
        prices {
            grand_total{
                value
            }
        }
    available_payment_methods{
        code
        title
    }
      shipping_addresses {
        selected_shipping_method {
          carrier_code
          carrier_title
          method_code
          method_title
          amount {
            value
            currency
          }
        }
      }
    }
  }
}
GRAPHQL;
$setGuestEmail = <<<'GRAPHQL'
mutation ($cartId: String!,$email: String!) {
  setGuestEmailOnCart(
    input: {
      cart_id: $cartId
      email: $email
    }
  ) {
    cart {
      email
    }
  }
}
GRAPHQL;
$setPaymentMethod = <<<'GRAPHQL'
mutation ($cartId: String!,$payment: String!) {
  setPaymentMethodOnCart(input: {
      cart_id: $cartId
      payment_method: {
          code: $payment
      }
  }) {
    cart {
      selected_payment_method {
        code
        title
      }
    }
  }
}
GRAPHQL;
$placeOrder = <<<'GRAPHQL'
mutation ($cartId: String!) {
  placeOrder(input: {cart_id: $cartId}) {
    orderV2 {
      number
      id
    }
    errors {
      message
      code
    }
  }
}
GRAPHQL;