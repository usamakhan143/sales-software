// API Base URL
const baseUrl = "http://127.0.0.1:8000/api"

// Checkboxes
const alreadyClient = document.getElementById('already-client');
const isRecurring = document.getElementById('is-recurring');
const isPartial = document.getElementById('is-partial');
const isPaymentLink = document.getElementById('is-payment-link');

// Selectors
const clientSelector = document.getElementById('client-selector');
const recurringSelector = document.getElementById('recurring-selector');
const partialSelector = document.getElementById('partial-amount');
const paymentLink = document.getElementById('payment-link');
const clientInfo = document.getElementById('client-info');

// Selectors Default State
clientSelector.style.display = "none";
recurringSelector.style.display = "none";
partialSelector.style.display = "none";
paymentLink.style.display = "none";


// If Client is already Exist
alreadyClient.addEventListener('change', function () {
    if (alreadyClient.checked) {
        // Get the select element by its ID
        var clientsSelector = document.getElementById('clientList');
        clientInfo.style.display = "none";
        clientSelector.style.display = "flex";

        fetch(`${baseUrl}/all-clients`)
            .then(response => response.json())
            .then(data => {
                // Call a function to populate the select field with the retrieved client data
                populateSelect(data.data, clientsSelector, 'Client');
            })
            .catch(error => {
                console.error('Error fetching clients:', error);
            });
    } else {
        clientInfo.style.display = "block";
        clientSelector.style.display = "none";
    }
});

// If Invoice is recurring
isRecurring.addEventListener('change', function () {
    if (isRecurring.checked) {
        recurringSelector.style.display = "flex";
    } else {
        recurringSelector.style.display = "none";
    }
});

// If Invoice is in partially paid behaviour
isPartial.addEventListener('change', function () {
    if (isPartial.checked) {
        partialSelector.style.display = "flex";
    } else {
        partialSelector.style.display = "none";
    }
});

// If payment link is available
isPaymentLink.addEventListener('change', function () {
    if (isPaymentLink.checked) {
        paymentLink.style.display = "flex";
    } else {
        paymentLink.style.display = "none";
    }
});



// Wait for the DOM content to load
document.addEventListener("DOMContentLoaded", function () {


    // Get Brands In the selector
    var brandsSelector = document.getElementById('brandsList');
    fetch(`${baseUrl}/all-brands`)
        .then(response => response.json())
        .then(data => {
            // Call a function to populate the select field with the retrieved client data
            populateSelect(data.data, brandsSelector, 'Brand');
        })
        .catch(error => {
            console.error('Error fetching clients:', error);
        });


    // Get the form element
    var form = document.getElementById("invoice");

    // Attach an event listener for the form submission
    form.addEventListener("submit", function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Get all the input elements within the form
        var inputs = form.querySelectorAll("input, select, textarea");

        // Create an object to store the field values
        var formData = {};

        // Loop through each input element
        inputs.forEach(function (input) {
            if (input.value.trim() !== "" && input.name) {
                // Check the type of input element
                switch (input.type) {
                    case "checkbox":
                        // If the checkbox is checked, assign a custom value
                        // Otherwise, assign an empty string
                        formData[input.name] = input.checked ? true : false;
                        break;
                    default:
                        // For other input types, store their values directly
                        formData[input.name] = input.value;
                        break;
                }
            }
        });

        // Output the form data to the console (you can do anything else with it)
        console.log(formData);

        // Alternatively, you can send the formData object to a server using AJAX

        // Reset the form after submission if needed
        // form.reset();
    });

    // Attach an event listener to the form to handle button clicks
    form.addEventListener("click", function (event) {
        // Check if the clicked element is a button and not the submit button
        if (event.target.tagName === "BUTTON" && !event.target.classList.contains("submit-btn")) {
            // Prevent the default button behavior
            event.preventDefault();
            // You can add additional logic here if needed
        }
    });
});


// Function to populate the select field with client data
function populateSelect(clients, element, text) {

    // Clear any existing options
    element.innerHTML = '';

    // Create a default option
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = `Select ${text} *`;
    element.appendChild(defaultOption);

    // Loop through the client data and create an option for each client
    clients.forEach(function (client) {
        var option = document.createElement('option');
        option.value = client.id; // Set the value of the option to the client ID
        option.textContent = client.name; // Set the text of the option to the client name
        element.appendChild(option);
    });
}