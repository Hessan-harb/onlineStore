<x-front-layout>
    <div class="account-login section">
        <div class="contanier">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                   <div id="payment-message" style="display: none;" class="alert alert-info"></div>

                   <form action="" method="post" id="payment-form">
                        <div id="payment-element"></div>
                        <button type="submit" id="submit" class="btn"> 
                            <span id="button-text">pay now</span>
                            <span id="spinner" style="display: none;">Processing...</span> 
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // This is your test publishable API key.
        const stripe = Stripe("{{config('services.stripe.publishable_key')}}");

        let elements;

        initialize();
        checkStatus();

        document
        .querySelector("#payment-form")
        .addEventListener("submit", handleSubmit);

        // Fetches a payment intent and captures the client secret
        async function initialize() {
        const { clientSecret } = await fetch("{{route('stripe.paymentIntent.create',$order->id)}}", {
            method: "POST",
            headers: { 
                "Content-Type": "application/json" 
            },
            body: JSON.stringify({
                 "_token": "{{ csrf_token() }}" 
            }),
        }).then((r) => r.json());

        elements = stripe.elements({
            clientSecret 
        });

        const paymentElementOptions = {
            layout: "tabs",
        };

        const paymentElement = elements.create("payment", paymentElementOptions);
        paymentElement.mount("#payment-element");
        }

        async function handleSubmit(e) {
        e.preventDefault();
        setLoading(true);

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: "{{route('stripe.return',$order->id)}}",
            },
        });

        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
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

        messageContainer.style.display="block";
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.style.display="none";
            messageContainer.textContent = "";
        }, 4000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").style.display="inline";
            document.querySelector("#button-text").style.display="none";
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").style.display="none";
            document.querySelector("#button-text").style.display="inline";
        }
        }
    </script>
</x-front-layout>