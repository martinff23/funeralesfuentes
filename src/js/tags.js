document.addEventListener("DOMContentLoaded", function () {
    function initializeTagsInput(inputSelector) {
        const tagsInput = document.querySelector(inputSelector);
        const tagsDiv = document.querySelector("#tags");
        const tagsHiddenInput = document.querySelector('[name="tags"]');
        
        if(tagsInput && tagsDiv && tagsHiddenInput){
            let tags = tagsHiddenInput.value ? tagsHiddenInput.value.split(",") : [];

            function updateHiddenInput() {
                tagsHiddenInput.value = tags.join(",");
            }

            function showTags() {
                tagsDiv.innerHTML = ""; // Limpiar antes de agregar nuevas etiquetas

                tags.forEach(tag => {
                    const tagTemp = document.createElement("LI");
                    tagTemp.classList.add("form__tag");
                    tagTemp.textContent = tag;
                    tagTemp.ondblclick = () => deleteTag(tag);
                    tagsDiv.appendChild(tagTemp);
                });
                updateHiddenInput();
            }

            function saveTag(event) {
                if (event.key === "," || event.key === "Enter") { // Detectar coma o Enter
                    event.preventDefault();
                    let newTag = event.target.value.trim().replace(/,$/, ""); // Quitar coma final si la hay

                    if (newTag.length > 0 && !tags.includes(newTag)) {
                        tags.push(newTag);

                        showTags();
                    }
                    tagsInput.value = ""; // Limpiar el input después de ingresar un tag
                }
            }

            function deleteTag(tag) {
                tags = tags.filter(t => t !== tag);

                showTags();
            }

            // Escuchar eventos en el input
            tagsInput.addEventListener("keydown", saveTag);

            // Mostrar los tags almacenados al iniciar
            showTags();
        }
    }

    initializeTagsInput("#package_tags");
    initializeTagsInput("#cemetery_tags");
    initializeTagsInput("#chapel_tags");
    initializeTagsInput("#complement_tags");
    initializeTagsInput("#crematory_tags");
    initializeTagsInput("#hearse_tags");
    initializeTagsInput("#product_tags");
    initializeTagsInput("#service_tags");
    initializeTagsInput("#branch_tags");
});

(function () {
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownConfigs = [
            { inputSearch: "#services_search", input: "[name='services_tags']", inputIds: "[name='services_tags_ids']", tagsDivId: "services_tags_div", dropdownSelector: "#services_dropdown", apiUrl: "/api/services", tagType: "service" },
            { inputSearch: "#complements_search", input: "[name='complements_tags']", inputIds: "[name='complements_tags_ids']", tagsDivId: "complements_tags_div", dropdownSelector: "#complements_dropdown", apiUrl: "/api/complements", tagType: "complement" },
            { inputSearch: "#chapels_search", input: "[name='chapels_tags']", inputIds: "[name='chapels_tags_ids']", tagsDivId: "chapels_tags_div", dropdownSelector: "#chapels_dropdown", apiUrl: "/api/chapels", tagType: "chapel" },
            { inputSearch: "#hearses_search", input: "[name='hearses_tags']", inputIds: "[name='hearses_tags_ids']", tagsDivId: "hearses_tags_div", dropdownSelector: "#hearses_dropdown", apiUrl: "/api/hearses", tagType: "hearse" },
            { inputSearch: "#cemeteries_search", input: "[name='cemeteries_tags']", inputIds: "[name='cemeteries_tags_ids']", tagsDivId: "cemeteries_tags_div", dropdownSelector: "#cemeteries_dropdown", apiUrl: "/api/cemeteries", tagType: "cemetery" },
            { inputSearch: "#crematories_search", input: "[name='crematories_tags']", inputIds: "[name='crematories_tags_ids']", tagsDivId: "crematories_tags_div", dropdownSelector: "#crematories_dropdown", apiUrl: "/api/crematories", tagType: "crematory" }
        ];

        function initializeDropdown(config) {
            const elementSearch = document.querySelector(config.inputSearch);
            if (!elementSearch) return;

            let elements = [];
            let filteredElements = [];
            let selectedIndex = -1;

            const hiddenInput = document.querySelector(config.input);
            const hiddenInputIds = document.querySelector(config.inputIds);
            let tags = hiddenInput.value ? hiddenInput.value.split(',') : [];
            let tagsIds = hiddenInputIds.value ? hiddenInputIds.value.split(',') : [];
            const dropdown = document.querySelector(config.dropdownSelector);
            const tagsDiv = document.getElementById(config.tagsDivId) || createTagsDiv(config.tagsDivId, elementSearch);

            fetchElements(config);

            elementSearch.addEventListener('input', (event) => searchElements(event, config));
            elementSearch.addEventListener("keydown", (event) => handleKeyboardNavigation(event, config));

            async function fetchElements(config) {
                try {
                    const response = await fetch(config.apiUrl);
                    const result = await response.json();
                    console.log(`Fetched data for ${config.tagType}:`, result);
                    formatElements(result, config);
                } catch (error) {
                    console.error(`Error fetching ${config.tagType}:`, error);
                }
            }

            function formatElements(arrayElements = [], config) {
                elements = arrayElements.map(element => ({
                    id: element.id,
                    name: element[`${config.tagType}_name`] ? element[`${config.tagType}_name`].trim() : ""
                }));

                removeExistingOptions();
            }

            function searchElements(event, config) {
                const search = normalizeSearch(event.target.value);
                if (search.length > 0) {
                    filteredElements = elements.filter(element =>
                        normalizeSearch(element.name).includes(search)
                    );
                    showDropdown(config);
                } else {
                    closeDropdown(config);
                }
            }

            function normalizeSearch(searchTerm) {
                return searchTerm.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
            }

            function showDropdown(config) {
                const dropdown = document.querySelector(config.dropdownSelector);
                dropdown.innerHTML = "";
                if (filteredElements.length === 0) {
                    dropdown.style.display = "none";
                    return;
                }

                dropdown.style.display = "block";
                selectedIndex = -1;

                filteredElements.forEach((element, index) => {
                    let option = document.createElement("div");
                    option.textContent = element.name;
                    option.dataset.id = element.id;
                    option.dataset.index = index;
                    option.onclick = () => selectOption(element.name, element.id, config);
                    dropdown.appendChild(option);
                });

                updateDropdownPosition(config);
            }

            function selectOption(name, id, config) {
                elementSearch.value = "";

                if (!tagsIds.includes(id.toString())) {
                    tags.push(name);
                    tagsIds.push(id.toString());
                    updateHiddenInput();
                    createTag(name, id, config);
                    removeFromElements(id);
                }

                closeDropdown(config);
            }

            function createTagsDiv(id, referenceElement) {
                let div = document.createElement("div");
                div.id = id;
                div.classList.add("tags-container");
                referenceElement.parentElement.appendChild(div);
                return div;
            }

            function updateHiddenInput() {
                hiddenInput.value = tags.join(',');
                hiddenInputIds.value = tagsIds.join(',');
            }

            function createTag(name, id, config) {
                const tag = document.createElement('li');
                tag.classList.add('form__tag');
                tag.textContent = name;
                tag.dataset.id = id;
                tag.ondblclick = () => deleteTag(name, id, config);
                tagsDiv.appendChild(tag);
            }

            function deleteTag(name, id, config) {
                const index = tagsIds.indexOf(id.toString());
                if (index !== -1) {
                    tags.splice(index, 1);
                    tagsIds.splice(index, 1);
                    updateHiddenInput(); // Actualizar el input oculto
            
                    // Remover la tag de la interfaz
                    const tagElement = tagsDiv.querySelector(`[data-id="${id}"]`);
                    if (tagElement) {
                        tagElement.remove();
                    }
            
                    restoreToElements(name, id); // Restaurar el elemento eliminado a la lista de opciones
                    showTags(); // Refrescar lista de tags
                }
            }

            function showTags() {
                tagsDiv.innerHTML = ""; // Limpiar antes de agregar nuevas etiquetas
            
                tags.forEach((tag, index) => {
                    const tagTemp = document.createElement("LI");
                    tagTemp.classList.add("form__tag");
                    tagTemp.textContent = tag;
                    tagTemp.setAttribute("data-id", tagsIds[index]);
            
                    // Asigna la función de eliminación correctamente
                    tagTemp.ondblclick = () => deleteTag(tag, tagsIds[index]);
            
                    tagsDiv.appendChild(tagTemp);
                });
            
                updateHiddenInput(); // Asegurar que el input oculto esté actualizado
            }

            function removeFromElements(id) {
                elements = elements.filter(element => element.id.toString() !== id.toString());
            }

            function restoreToElements(name, id) {
                elements.push({ id, name });
            }

            function removeExistingOptions() {
                tagsIds.forEach(tagId => {
                    removeFromElements(tagId);
                });
            }

            function updateDropdownPosition(config) {
                const elementSearch = document.querySelector(config.inputSearch);
                const dropdown = document.querySelector(config.dropdownSelector);

                let rect = elementSearch.getBoundingClientRect();
                dropdown.style.top = (rect.height) + "px";
                dropdown.style.width = rect.width + "px";
            }

            function handleKeyboardNavigation(event, config) {
                const dropdown = document.querySelector(config.dropdownSelector);
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
                    selectOption(selectedOption.textContent, selectedOption.dataset.id, config);
                    return;
                } else if (event.key === "Escape") {
                    closeDropdown(config);
                    return;
                }

                options.forEach((option, index) => {
                    option.classList.toggle("selected", index === selectedIndex);
                });
            }

            function closeDropdown(config) {
                const dropdown = document.querySelector(config.dropdownSelector);
                dropdown.innerHTML = "";
                dropdown.style.display = "none";
                selectedIndex = -1;
            }

            window.addEventListener("scroll", () => dropdownConfigs.forEach(updateDropdownPosition));
            window.addEventListener("resize", () => dropdownConfigs.forEach(updateDropdownPosition));

            document.addEventListener("click", function (event) {
                dropdownConfigs.forEach(config => {
                    const elementSearch = document.querySelector(config.inputSearch);
                    if (event.target !== elementSearch && event.target.closest(".dropdown") === null) {
                        closeDropdown(config);
                    }
                });
            });

            showTags();
        }

        dropdownConfigs.forEach(initializeDropdown);
    });
})();