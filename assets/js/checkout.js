// This is your test publishable API key.
const stripe = Stripe("pk_test_51K3xsPSDQHE9e11yo66oFzwlAEETm1OQKpr60hoI2BcZTQU0G2AW5K1XytzTh8NjTNYBex1e0fFJFg8TM1l9QHv500JKgkzf5j");

// The items the customer wants to buy
// const items = [{ id: "xl-tshirt" }];
var item_id = document.getElementById("product_id").value;
const items = { id: "xl-tshirt",pdt_id: item_id };
// console.log(JSON.stringify({ items }));

let elements;

initialize();
checkStatus();

document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
  const { clientSecret } = await fetch("http://localhost/stripe-sample-code/checkout/create.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ items }),
  }).then((r) => r.json());

  elements = stripe.elements({ clientSecret });

  // const paymentElement = elements.create("payment");
  var paymentElement = elements.create('payment', {
    fields: {
      billingDetails: {
        name: 'auto',
        email: 'auto',
        
      }
    }
  });
  
  paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);
  var cst_name = document.getElementById("cst_name").value;
  var cst_email = document.getElementById("cst_email").value;
  var country = document.getElementById("Field-countryInput").value;
  var line1 = document.getElementById("line1").value;
  var line2 = document.getElementById("line2").value;
  var city = document.getElementById("city").value;
  var zip = document.getElementById("zip").value;
  var state = document.getElementById("state").value;
  const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url: "http://localhost/stripe-sample-code/checkout/success.php",
      payment_method_data: {
        billing_details: {
          name: cst_name,
          email: cst_email,
          address: {
            "city": city,
            "country": country,
            "line1": line1,
            "line2": line2,
            "postal_code": zip,
            "state": state
          },
        }
      },
    },
  });

  // This point will only be reached if there is an immediate error when
  // confirming the payment. Otherwise, your customer will be redirected to
  // your `return_url`. For some payment methods like iDEAL, your customer will
  // be redirected to an intermediate site first to authorize the payment, then
  // redirected to the `return_url`.
  if (error.type === "card_error" || error.type === "validation_error") {
    showMessage(error.message);
  } else {
    showMessage(error.message);
  }

  setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
  const clientSecret = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
  );

  if (!clientSecret) {
    return;
  }

  const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

  switch (paymentIntent.status) {
    case "succeeded":
      showMessage("Payment succeeded!");
      break;
    case "processing":
      showMessage("Your payment is processing.");
      break;
    case "requires_payment_method":
      showMessage("Your payment was not successful, please try again.");
      break;
    default:
      showMessage("Something went wrong.");
      break;
  }
}

// ------- UI helpers -------

function showMessage(messageText) {
  const messageContainer = document.querySelector("#payment-message");

  messageContainer.classList.remove("hidden");
  messageContainer.textContent = messageText;

  setTimeout(function () {
    messageContainer.classList.add("hidden");
    messageText.textContent = "";
  }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
}