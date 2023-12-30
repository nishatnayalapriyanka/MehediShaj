function addressAutocomplete(containerElement, callback, options) {
    const inputElement = containerElement.querySelector("input");
    const autocompleteItemsElement = containerElement.querySelector(".autocomplete-items");

    // Initialize variables
    let currentTimeout;
    let currentPromiseReject;
    let focusedItemIndex = -1;

    // Process a user input
    inputElement.addEventListener("input", function (e) {
        const currentValue = this.value;

        // Cancel previous timeout
        if (currentTimeout) {
            clearTimeout(currentTimeout);
        }

        // Cancel previous request promise
        if (currentPromiseReject) {
            currentPromiseReject({ canceled: true });
        }

        // Hide the dropdown initially
        autocompleteItemsElement.style.display = "none";

        // Skip empty or short address strings
        if (!currentValue || currentValue.length < MIN_ADDRESS_LENGTH) {
            return false;
        }

        // Call the Address Autocomplete API with a delay
        currentTimeout = setTimeout(() => {
            currentTimeout = null;

            // Create a new promise and send geocoding request
            const promise = new Promise((resolve, reject) => {
                currentPromiseReject = reject;

                // Get an API Key on https://myprojects.geoapify.com
                const apiKey = "a8fa1b9e1862409e9f2424ff57db481f";

                const url = `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(
                    currentValue
                )}&format=json&limit=5&apiKey=${apiKey}`;

                fetch(url)
                    .then((response) => {
                        currentPromiseReject = null;

                        // Check if the call was successful
                        if (response.ok) {
                            response.json().then((data) => resolve(data));
                        } else {
                            response.json().then((data) => reject(data));
                        }
                    });
            });

            promise.then(
                (data) => {
                    currentItems = data.results;

                    // Check if there are results before displaying the dropdown box
                    if (currentItems.length > 0) {
                        // Create a DIV element that will contain the items (values):
                        autocompleteItemsElement.innerHTML = "";

                        // For each item in the results
                        data.results.forEach((result, index) => {
                            // Create a DIV element for each element:
                            const itemElement = document.createElement("div");

                            // Set formatted address as item value
                            itemElement.innerHTML = `<i class="fa-solid fa-location-dot"></i> ${result.formatted}`;
                            autocompleteItemsElement.appendChild(itemElement);

                            // Set the value for the autocomplete text field and notify:
                            itemElement.addEventListener("click", function (e) {
                                inputElement.value = currentItems[index].formatted;
                                callback(currentItems[index]);
                                autocompleteItemsElement.style.display = "none"; // Hide the dropdown after selection
                            });
                        });

                        // Display the dropdown
                        autocompleteItemsElement.style.display = "block";
                    }
                },
                (err) => {
                    if (!err.canceled) {
                        console.log(err);
                    }
                }
            );
        }, DEBOUNCE_DELAY);
    });

    // Add support for keyboard navigation
    inputElement.addEventListener("keydown", function (e) {
        const itemElements = autocompleteItemsElement.getElementsByTagName("div");
        if (e.keyCode === 40) {
            e.preventDefault();
            focusedItemIndex = focusedItemIndex !== itemElements.length - 1 ? focusedItemIndex + 1 : 0;
            setActive(itemElements, focusedItemIndex);
        } else if (e.keyCode === 38) {
            e.preventDefault();
            focusedItemIndex = focusedItemIndex !== 0 ? focusedItemIndex - 1 : focusedItemIndex = itemElements.length - 1;
            setActive(itemElements, focusedItemIndex);
        } else if (e.keyCode === 13) {
            e.preventDefault();
            if (focusedItemIndex > -1) {
                inputElement.value = currentItems[focusedItemIndex].formatted;
                callback(currentItems[focusedItemIndex]);
                autocompleteItemsElement.style.display = "none"; // Hide the dropdown after selection
            }
        }
    });

    function setActive(items, index) {
        if (!items || !items.length) return false;

        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove("autocomplete-active");
        }

        items[index].classList.add("autocomplete-active");

        inputElement.value = currentItems[index].formatted;
        callback(currentItems[index]);
    }
}

const MIN_ADDRESS_LENGTH = 3;
const DEBOUNCE_DELAY = 300;

addressAutocomplete(document.getElementById("autocomplete-container"), (data) => {
    console.log("Selected option: ");
    console.log(data);
}, {
    placeholder: "Enter an address here"
});

// Close the autocomplete dropdown when the document is clicked
document.addEventListener("click", function (e) {
    const containerElement = document.getElementById("autocomplete-container");
    const inputElement = containerElement.querySelector("input");
    const autocompleteItemsElement = containerElement.querySelector(".autocomplete-items");
    if (e.target !== inputElement && e.target !== autocompleteItemsElement) {
        autocompleteItemsElement.style.display = "none";
    }
});
