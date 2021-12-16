
const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);

// The items the customer wants to buy
// const items = [{ id: "xl-tshirt" }];
var itemId = document.getElementById("productId").value;
const items = { id: "xl-tshirt",pdtId: itemId };
// console.log(STRIPE_PUBLISHABLE_KEY);
var payIntid ='';
let elements;


initialize();
checkStatus();

document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
  const { clientSecret,id } = await fetch(URLROOT+"app/services/payments/StripePayment.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ items }),
  }).then((r) => r.json());

  elements = stripe.elements({ clientSecret });
  payIntid = id;
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
  $(".valid-address").text('');
  var cstName = document.getElementById("cstName").value;
  var cstEmail = document.getElementById("cstEmail").value;
  var billLine1 = document.getElementById("billLine1").value;
  var billLine2 = document.getElementById("billLine2").value;
  var billCity = document.getElementById("billCity").value;
  var billZip = document.getElementById("billZip").value;
  var billState = document.getElementById("billState").value; 
  var shipLine1 = document.getElementById("shipLine1").value;
  var shipLine2 = document.getElementById("shipLine2").value;
  var shipCity = document.getElementById("shipCity").value;
  var shipZip = document.getElementById("shipZip").value;
  var shipCountry = document.getElementById("shipCountry").value; 
  var shipState = document.getElementById("shipState").value; 
  var shipName = document.getElementById("shipName").value; 
  var div = document.getElementsByClassName('panel-custom');
  var i = 0 ;
  var formData={};
  formData['product_id'] = items.pdtId;
  formData['email'] = cstEmail;
  formData['payment_intent'] = payIntid;
  formData['client_secret'] = '';
  $(div).find('input, select, textarea').each(function() {
    // console.log($(this).val());
    if(!$(this).val()){
      var text = $(this).siblings('label').text();
      $(this).siblings('span').text("The "+text+" is Required");
      i++;
    }else{
      formData[$(this).attr('name')] = $(this).val();
    }
  });
  // console.log(formData);
  if(i != 0){
    setLoading(false);
    return;
  }
  
    if(formData){
      $.ajax({
        url: URLROOT+"orders/createOrder",
        method : "POST",
        data:{formdata:JSON.stringify(formData)},
      }).done(function( data ) {
        //   console.log(data);
        
      });
    }
  
  
  const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url: STRIPE_SUCCESS_URL,
      payment_method_data: {
        billing_details: {
          name: cstName,
          email: cstEmail,
          address: {
            "city": billCity,
            // "country": country,
            "line1": billLine1,
            "line2": billLine2,
            "postal_code": billZip,
            "state": billState
          },
        },
        
      },
      shipping: {
        name: shipName,
        address: {
            line1: shipLine1,
            line2: shipLine2,
            city: shipCity,
            postal_code: shipZip,
            state: shipState,
            country: shipCountry,
        },
        
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
console.log(paymentIntent);
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