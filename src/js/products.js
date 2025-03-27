(function() {
    function initializeDropdown(config) {
        const productSearch = document.querySelector(config.inputSelector);
        if (!productSearch) return;

        let products = [];
        let filteredProducts = [];
        let selectedIndex = -1;

        const productHidden = document.querySelector(config.hiddenInputSelector);
        const dropdown = document.querySelector(config.dropdownSelector);

        fetchProducts();

        productSearch.addEventListener('input', searchProducts);
        productSearch.addEventListener('change', selectProduct);
        productSearch.addEventListener("keydown", handleKeyboardNavigation);

        async function fetchProducts() {
            const response = await fetch(config.apiUrl);
            const result = await response.json();
            formatProducts(result);
        }

        function formatProducts(arrayProducts = []) {
            products = arrayProducts.map(product => ({
                id: product.id,
                product_name: product.product_name.trim()
            }));
        }

        function searchProducts(event) {
            const search = normalizeSearch(event.target.value);
            if (search.length > 0) {
                filteredProducts = products.filter(product => 
                    normalizeSearch(product.product_name).includes(search)
                );
                showDropdown();
            } else {
                closeDropdown();
            }
        }

        function normalizeSearch(searchTerm) {
            return searchTerm.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        }

        function selectProduct(event) {
            const selectedValue = event.target.value;
            const selectedProduct = products.find(product => product.product_name === selectedValue);
            productHidden.value = selectedProduct ? selectedProduct.id : "";
        }

        function showDropdown() {
            dropdown.innerHTML = "";
            if (filteredProducts.length === 0) {
                dropdown.style.display = "none";
                return;
            }

            dropdown.style.display = "block";
            selectedIndex = -1;

            filteredProducts.forEach((product, index) => {
                let option = document.createElement("div");
                option.textContent = product.product_name;
                option.dataset.id = product.id;
                option.dataset.index = index;
                option.onclick = () => selectOption(product.product_name, product.id);
                dropdown.appendChild(option);
            });

            updateDropdownPosition();
        }

        function selectOption(name, id) {
            productSearch.value = name;
            productHidden.value = id;
            closeDropdown();
        }

        function updateDropdownPosition() {
            let rect = productSearch.getBoundingClientRect();
            dropdown.style.top = (rect.height) + "px";
            dropdown.style.width = rect.width + "px";
        }

        function handleKeyboardNavigation(event) {
            let options = dropdown.querySelectorAll("div");
            if (dropdown.style.display === "none" || options.length === 0) return;

            if (event.key === "ArrowDown") {
                event.preventDefault();
                selectedIndex = (selectedIndex + 1) % options.length;
            } else if (event.key === "ArrowUp") {
                event.preventDefault();
                selectedIndex = (selectedIndex - 1 + options.length) % options.length;
            } else if (event.key === "Enter" && selectedIndex !== -1) {
                event.preventDefault();
                let selectedOption = options[selectedIndex];
                selectOption(selectedOption.textContent, selectedOption.dataset.id);
                return;
            } else if (event.key === "Escape") {
                closeDropdown();
                return;
            }

            options.forEach((option, index) => {
                option.classList.toggle("selected", index === selectedIndex);
            });
        }

        function closeDropdown() {
            dropdown.innerHTML = "";
            dropdown.removeAttribute("style");
            dropdown.style.display = "none";
            selectedIndex = -1;
        }

        window.addEventListener("scroll", updateDropdownPosition);
        window.addEventListener("resize", updateDropdownPosition);

        document.addEventListener("click", function(event) {
            if (event.target !== productSearch && event.target.closest(".dropdown") === null) {
                closeDropdown();
            }
        });
    }

    // 🔹 Inicializar dropdowns
    initializeDropdown({
        inputSelector: "#coffin_search",
        hiddenInputSelector: "[name='coffin_id']",
        dropdownSelector: "#coffins_dropdown",
        apiUrl: "/api/coffins"
    });

    initializeDropdown({
        inputSelector: "#urn_search",
        hiddenInputSelector: "[name='urn_id']",
        dropdownSelector: "#urns_dropdown",
        apiUrl: "/api/urns"
    });

})();