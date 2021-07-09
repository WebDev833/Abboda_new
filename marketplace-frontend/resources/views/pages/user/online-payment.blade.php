<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  /* Variables */
  :root {
    --body-color: rgb(247, 250, 252);
    --button-color: #115c5d;
    --accent-color: #115c5d;
    --link-color: #ffffff;
    --font-color: rgb(105, 115, 134);
    --body-font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    --radius: 6px;
    --form-width: 400px;
  }

  /* Base */
  * {
    box-sizing: border-box;
  }
  body {
    font-family: var(--body-font-family);
    font-size: 16px;
    -webkit-font-smoothing: antialiased;
  }

  /* Layout */
  .sr-root {
    display: flex;
    flex-direction: row;
    width: 100%;
    max-width: 980px;
    padding: 48px;
    align-content: center;
    justify-content: center;
    height: auto;
    /* min-height: 100vh; */
    min-height: 60vh;
    margin: 0 auto;
  }
  .sr-main {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    align-self: center;
    padding: 75px 50px;
    background: var(--body-color);
    width: var(--form-width);
    border-radius: var(--radius);
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
    0px 2px 5px 0px rgba(50, 50, 93, 0.1),
    0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
  }

  .sr-field-error {
    color: var(--font-color);
    text-align: left;
    font-size: 13px;
    line-height: 17px;
    margin-top: 12px;
  }

  /* Inputs */
  .sr-input,
  input[type="text"] {
    border: 1px solid var(--gray-border);
    border-radius: var(--radius);
    padding: 5px 12px;
    height: 44px;
    width: 100%;
    transition: box-shadow 0.2s ease;
    background: white;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
  }
  .sr-input:focus,
  input[type="text"]:focus,
  button:focus,
  .focused {
    box-shadow: 0 0 0 1px rgba(50, 151, 211, 0.3), 0 1px 1px 0 rgba(0, 0, 0, 0.07),
      0 0 0 4px rgba(50, 151, 211, 0.3);
    outline: none;
    z-index: 9;
  }
  .sr-input::placeholder,
  input[type="text"]::placeholder {
    color: var(--gray-light);
  }
  .sr-result {
    height: 44px;
    -webkit-transition: height 1s ease;
    -moz-transition: height 1s ease;
    -o-transition: height 1s ease;
    transition: height 1s ease;
    color: var(--font-color);
    overflow: auto;
  }
  .sr-result code {
    overflow: scroll;
  }
  .sr-result.expand {
    height: 350px;
  }

  .sr-combo-inputs-row {
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
      0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
    border-radius: 7px;
  }

  /* Buttons and links */
  button {
    background: var(--accent-color);
    border-radius: var(--radius);
    color: white;
    border: 0;
    padding: 12px 16px;
    margin-top: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: block;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
  }
  button:hover {
    filter: contrast(115%);
  }
  button:active {
    transform: translateY(0px) scale(0.98);
    filter: brightness(0.9);
  }
  button:disabled {
    opacity: 0.5;
    cursor: none;
  }

  a {
    color: var(--link-color);
    text-decoration: none;
    transition: all 0.2s ease;
  }

  a:hover {
    filter: brightness(0.8);
  }

  a:active {
    filter: brightness(0.5);
  }

  /* Code block */
  code,
  pre {
    font-family: "SF Mono", "IBM Plex Mono", "Menlo", monospace;
    font-size: 12px;
  }

  /* Stripe Element placeholder */
  .sr-card-element {
    padding-top: 12px;
  }

  /* Responsiveness */
  @media (max-width: 720px) {
    .sr-root {
      flex-direction: column;
      justify-content: flex-start;
      /* padding: 48px 20px; */
      padding: 15px 5px;
      min-width: 320px;
    }

    .sr-header__logo {
      background-position: center;
    }

    .sr-payment-summary {
      text-align: center;
    }

    .sr-content {
      display: none;
    }

    .sr-main {
      width: 100%;
      height: 305px;
      background: rgb(247, 250, 252);
      box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
        0px 2px 5px 0px rgba(50, 50, 93, 0.1),
        0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
      border-radius: 6px;
      padding: 10px 10px;
    }
  }

  /* todo: spinner/processing state, errors, animations */

  .spinner,
  .spinner:before,
  .spinner:after {
    border-radius: 50%;
  }
  .spinner {
    color: #ffffff;
    font-size: 22px;
    text-indent: -99999px;
    margin: 0px auto;
    position: relative;
    width: 20px;
    height: 20px;
    box-shadow: inset 0 0 0 2px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
  }
  .spinner:before,
  .spinner:after {
    position: absolute;
    content: "";
  }
  .spinner:before {
    width: 10.4px;
    height: 20.4px;
    background: var(--accent-color);
    border-radius: 20.4px 0 0 20.4px;
    top: -0.2px;
    left: -0.2px;
    -webkit-transform-origin: 10.4px 10.2px;
    transform-origin: 10.4px 10.2px;
    -webkit-animation: loading 2s infinite ease 1.5s;
    animation: loading 2s infinite ease 1.5s;
  }
  .spinner:after {
    width: 10.4px;
    height: 10.2px;
    background: var(--accent-color);
    border-radius: 0 10.2px 10.2px 0;
    top: -0.1px;
    left: 10.2px;
    -webkit-transform-origin: 0px 10.2px;
    transform-origin: 0px 10.2px;
    -webkit-animation: loading 2s infinite ease;
    animation: loading 2s infinite ease;
  }

  @-webkit-keyframes loading {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @keyframes loading {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  /* Animated form */

  .sr-root {
    animation: 0.4s form-in;
    animation-fill-mode: both;
    animation-timing-function: ease;
  }

  .hidden {
    display: none;
  }

  @keyframes field-in {
    0% {
      opacity: 0;
      transform: translateY(8px) scale(0.95);
    }
    100% {
      opacity: 1;
      transform: translateY(0px) scale(1);
    }
  }

  @keyframes form-in {
    0% {
      opacity: 0;
      transform: scale(0.98);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>
</head>
<body>
  <div class="globalContent">
    <main>
      <section class="container-lg">
        <div class="introduction" style="text-align:center;">
          <img src="http://frontendmarketplace.com/images/abboda-logo.png" style="margin: 40px 0;">
          <h2 style="margin:0;">Complete your Order Payment</h2>
          </div>
          <div class="sr-root">
                <div class="sr-main">
                    <form id="payment-form" class="sr-payment-form">
                        <div class="sr-combo-inputs-row">
                            <div class="sr-input sr-card-element" id="card-element"></div>
                        </div>
                        <div class="sr-field-error" id="card-errors" role="alert"></div>
                        <button id="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay </span><span id="order-amount">{{ romsProPrice($order['amount'],false) }}</span>
                        </button>
                    </form>
                    <div class="sr-result hidden">
                        <p>Payment completed<br /></p>
                        <pre>
                    <code></code>
                  </pre>
                    </div>
                </div>
            </div>
      </section>
    </main>
  </div>
    <script src="https://js.stripe.com/v3/"></script>
  <script>
    var stripe;

    // Disable the button until we have Stripe set up on the page
    document.querySelector("button").disabled = true;
   var myPGay = function()
    {
      return new Promise(function(resolve, reject) {
        resolve({
                  publishableKey: "{{ $payment['publishableKey'] }}",
                  clientSecret: "{{ $payment['clientSecret'] }}",
                });
      });     
    };

    myPGay().then(function (data) {
            return setupElements(data);
        }).then(function ({
            stripe,
            card,
            clientSecret
        }) {
            document.querySelector("button").disabled = false;

            // Handle form submission.
            var form = document.getElementById("payment-form");
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                // Initiate payment when the submit button is clicked
                pay(stripe, card, clientSecret);
            });
        });

   // Set up Stripe.js and Elements to use in checkout form
   var setupElements = function (data) {
        stripe = Stripe(data.publishableKey);
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", {
            style: style
        });
        card.mount("#card-element");

        return {
            stripe: stripe,
            card: card,
            clientSecret: data.clientSecret
        };
   };
    /*
     * Calls stripe.confirmCardPayment which creates a pop-up modal to
     * prompt the user to enter extra authentication details without leaving your page
     */
    var pay = function (stripe, card, clientSecret) {
        changeLoadingState(true);

        // Initiate the payment.
        // If authentication is required, confirmCardPayment will automatically display a modal
        stripe
            .confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            })
            .then(function (result) {
                if (result.error) {
                    // Show error to your customer
                    // either card is correct
                    // or insufficient balance. 
                    showError(result.error.message);

                } else {
                    // The payment has been processed!
                    orderComplete(clientSecret);
                }
            });
    };

    /* ------- Post-payment helpers ------- */

    /* Shows a success / error message when the payment is complete */
    var orderComplete = function (clientSecret) {
        // Just for the purpose of the sample, show the PaymentIntent response object
        stripe.retrievePaymentIntent(clientSecret).then(function (result) {
          // payment completed -> do something for this customer.
          // ajax 
          var payData = {
            order_id : "{{ $order['order_id']}}",
            amount : "{{ $order['amount']}}",
            status : "Completed"
          };
            fetch("{{route('user.completePayment')}}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payData)
            }).then(function(result){
              return result.json();
            }).then(function(data){
              console.log(data);
              if(data.error == false)
              {
                window.location.href = "{{ route('orderconfirmationpage', ['status' => 'success']) }}";
              }

            });
            
            /*
            var paymentIntent = result.paymentIntent;
            var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

            document.querySelector(".sr-payment-form").classList.add("hidden");
            document.querySelector("pre").textContent = paymentIntentJson;

            document.querySelector(".sr-result").classList.remove("hidden");
            setTimeout(function () {
                document.querySelector(".sr-result").classList.add("expand");
            }, 200);
            */

            document.getElementById("payment-form").reset();
            changeLoadingState(false);
          

        });
    };

    var showError = function (errorMsgText) {
        changeLoadingState(false);
        var errorMsg = document.querySelector(".sr-field-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function () {
            errorMsg.textContent = "";
        }, 4000);
    };

    // Show a spinner on payment submission
    var changeLoadingState = function (isLoading) {
        if (isLoading) {
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    };

</script>
</body>
</html>

{{-- 
@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-contact-info">
    <div class="container">
        <div class="ps-section__header">
            <h3 class="mb-3">Complete your Order Payment </h3>
        </div>
        <div class="ps-section__content">
            <div class="sr-root">
                <div class="sr-main">
                    <form id="payment-form" class="sr-payment-form">
                        <div class="sr-combo-inputs-row">
                            <div class="sr-input sr-card-element" id="card-element"></div>
                        </div>
                        <div class="sr-field-error" id="card-errors" role="alert"></div>
                        <button id="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay</span><span id="order-amount"></span>
                        </button>
                    </form>
                    <div class="sr-result hidden">
                        <p>Payment completed<br /></p>
                        <pre>
                    <code></code>
                  </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe;

    var orderData = {
        items: [{
            id: "photo-subscription"
        }],
        currency: "usd"
    };

    // Disable the button until we have Stripe set up on the page
    document.querySelector("button").disabled = true;

    fetch("/user/intent", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(orderData)
        })
        .then(function (result) {
            return result.json();
        })
        .then(function (data) {
            console.log(data);
            console.log('setting elems');
            return setupElements(data);
        })
        .then(function ({
            stripe,
            card,
            clientSecret
        }) {
            document.querySelector("button").disabled = false;

            // Handle form submission.
            var form = document.getElementById("payment-form");
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                // Initiate payment when the submit button is clicked
                pay(stripe, card, clientSecret);
            });
        });

    // Set up Stripe.js and Elements to use in checkout form
    var setupElements = function (data) {
        stripe = Stripe(data.publishableKey);
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", {
            style: style
        });
        card.mount("#card-element");

        return {
            stripe: stripe,
            card: card,
            clientSecret: data.clientSecret
        };
    };

    /*
     * Calls stripe.confirmCardPayment which creates a pop-up modal to
     * prompt the user to enter extra authentication details without leaving your page
     */
    var pay = function (stripe, card, clientSecret) {
        changeLoadingState(true);

        // Initiate the payment.
        // If authentication is required, confirmCardPayment will automatically display a modal
        stripe
            .confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            })
            .then(function (result) {
                if (result.error) {
                    // Show error to your customer
                    showError(result.error.message);
                } else {
                    // The payment has been processed!
                    orderComplete(clientSecret);
                }
            });
    };

    /* ------- Post-payment helpers ------- */

    /* Shows a success / error message when the payment is complete */
    var orderComplete = function (clientSecret) {
        // Just for the purpose of the sample, show the PaymentIntent response object
        stripe.retrievePaymentIntent(clientSecret).then(function (result) {
            var paymentIntent = result.paymentIntent;
            var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

            document.querySelector(".sr-payment-form").classList.add("hidden");
            document.querySelector("pre").textContent = paymentIntentJson;

            document.querySelector(".sr-result").classList.remove("hidden");
            setTimeout(function () {
                document.querySelector(".sr-result").classList.add("expand");
            }, 200);

            changeLoadingState(false);
        });
    };

    var showError = function (errorMsgText) {
        changeLoadingState(false);
        var errorMsg = document.querySelector(".sr-field-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function () {
            errorMsg.textContent = "";
        }, 4000);
    };

    // Show a spinner on payment submission
    var changeLoadingState = function (isLoading) {
        if (isLoading) {
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    };

</script>
@endsection

@section('page-styles')
<style>
  /* Variables */
  :root {
    --body-color: rgb(247, 250, 252);
    --button-color: rgb(30, 166, 114);
    --accent-color: #0a721b;
    --link-color: #ffffff;
    --font-color: rgb(105, 115, 134);
    --body-font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    --radius: 6px;
    --form-width: 400px;
  }

  /* Base */
  * {
    box-sizing: border-box;
  }
  body {
    font-family: var(--body-font-family);
    font-size: 16px;
    -webkit-font-smoothing: antialiased;
  }

  /* Layout */
  .sr-root {
    display: flex;
    flex-direction: row;
    width: 100%;
    max-width: 980px;
    padding: 48px;
    align-content: center;
    justify-content: center;
    height: auto;
    min-height: 100vh;
    margin: 0 auto;
  }
  .sr-main {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    align-self: center;
    padding: 75px 50px;
    background: var(--body-color);
    width: var(--form-width);
    border-radius: var(--radius);
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
    0px 2px 5px 0px rgba(50, 50, 93, 0.1),
    0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
  }

  .sr-field-error {
    color: var(--font-color);
    text-align: left;
    font-size: 13px;
    line-height: 17px;
    margin-top: 12px;
  }

  /* Inputs */
  .sr-input,
  input[type="text"] {
    border: 1px solid var(--gray-border);
    border-radius: var(--radius);
    padding: 5px 12px;
    height: 44px;
    width: 100%;
    transition: box-shadow 0.2s ease;
    background: white;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
  }
  .sr-input:focus,
  input[type="text"]:focus,
  button:focus,
  .focused {
    box-shadow: 0 0 0 1px rgba(50, 151, 211, 0.3), 0 1px 1px 0 rgba(0, 0, 0, 0.07),
      0 0 0 4px rgba(50, 151, 211, 0.3);
    outline: none;
    z-index: 9;
  }
  .sr-input::placeholder,
  input[type="text"]::placeholder {
    color: var(--gray-light);
  }
  .sr-result {
    height: 44px;
    -webkit-transition: height 1s ease;
    -moz-transition: height 1s ease;
    -o-transition: height 1s ease;
    transition: height 1s ease;
    color: var(--font-color);
    overflow: auto;
  }
  .sr-result code {
    overflow: scroll;
  }
  .sr-result.expand {
    height: 350px;
  }

  .sr-combo-inputs-row {
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
      0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
    border-radius: 7px;
  }

  /* Buttons and links */
  button {
    background: var(--accent-color);
    border-radius: var(--radius);
    color: white;
    border: 0;
    padding: 12px 16px;
    margin-top: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: block;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
  }
  button:hover {
    filter: contrast(115%);
  }
  button:active {
    transform: translateY(0px) scale(0.98);
    filter: brightness(0.9);
  }
  button:disabled {
    opacity: 0.5;
    cursor: none;
  }

  a {
    color: var(--link-color);
    text-decoration: none;
    transition: all 0.2s ease;
  }

  a:hover {
    filter: brightness(0.8);
  }

  a:active {
    filter: brightness(0.5);
  }

  /* Code block */
  code,
  pre {
    font-family: "SF Mono", "IBM Plex Mono", "Menlo", monospace;
    font-size: 12px;
  }

  /* Stripe Element placeholder */
  .sr-card-element {
    padding-top: 12px;
  }

  /* Responsiveness */
  @media (max-width: 720px) {
    .sr-root {
      flex-direction: column;
      justify-content: flex-start;
      padding: 48px 20px;
      min-width: 320px;
    }

    .sr-header__logo {
      background-position: center;
    }

    .sr-payment-summary {
      text-align: center;
    }

    .sr-content {
      display: none;
    }

    .sr-main {
      width: 100%;
      height: 305px;
      background: rgb(247, 250, 252);
      box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
        0px 2px 5px 0px rgba(50, 50, 93, 0.1),
        0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
      border-radius: 6px;
    }
  }

  /* todo: spinner/processing state, errors, animations */

  .spinner,
  .spinner:before,
  .spinner:after {
    border-radius: 50%;
  }
  .spinner {
    color: #ffffff;
    font-size: 22px;
    text-indent: -99999px;
    margin: 0px auto;
    position: relative;
    width: 20px;
    height: 20px;
    box-shadow: inset 0 0 0 2px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
  }
  .spinner:before,
  .spinner:after {
    position: absolute;
    content: "";
  }
  .spinner:before {
    width: 10.4px;
    height: 20.4px;
    background: var(--accent-color);
    border-radius: 20.4px 0 0 20.4px;
    top: -0.2px;
    left: -0.2px;
    -webkit-transform-origin: 10.4px 10.2px;
    transform-origin: 10.4px 10.2px;
    -webkit-animation: loading 2s infinite ease 1.5s;
    animation: loading 2s infinite ease 1.5s;
  }
  .spinner:after {
    width: 10.4px;
    height: 10.2px;
    background: var(--accent-color);
    border-radius: 0 10.2px 10.2px 0;
    top: -0.1px;
    left: 10.2px;
    -webkit-transform-origin: 0px 10.2px;
    transform-origin: 0px 10.2px;
    -webkit-animation: loading 2s infinite ease;
    animation: loading 2s infinite ease;
  }

  @-webkit-keyframes loading {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @keyframes loading {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  /* Animated form */

  .sr-root {
    animation: 0.4s form-in;
    animation-fill-mode: both;
    animation-timing-function: ease;
  }

  .hidden {
    display: none;
  }

  @keyframes field-in {
    0% {
      opacity: 0;
      transform: translateY(8px) scale(0.95);
    }
    100% {
      opacity: 1;
      transform: translateY(0px) scale(1);
    }
  }

  @keyframes form-in {
    0% {
      opacity: 0;
      transform: scale(0.98);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>
@endsection --}}
