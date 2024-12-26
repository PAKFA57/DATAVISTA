document.getElementById('loadDates').addEventListener('click', () => {
    const storeSelect = document.getElementById('storeSelect');
    const storeId = storeSelect.value;
    const storeName = storeSelect.options[storeSelect.selectedIndex].text;

    if (!storeId) {
        alert('Выберите магазин');
        return;
    }

    fetch(`load_dates.php?store_id=${storeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const startDate = document.getElementById('startDate');
                const endDate = document.getElementById('endDate');

                startDate.innerHTML = '';
                endDate.innerHTML = '';

                data.dates.forEach(date => {
                    const option = document.createElement('option');
                    option.value = date;
                    option.textContent = date;
                    startDate.appendChild(option);
                    endDate.appendChild(option.cloneNode(true));
                });

                document.getElementById('selectedStoreName').value = storeName;
                document.getElementById('selectedStoreId').value = storeId;

                document.getElementById('dateRangeForm').style.display = 'block';
            } else {
                alert('Нет данных для выбранного магазина');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Ошибка при загрузке дат');
        });
});

function toggleSection1(sectionId) {
    var section = document.getElementById(sectionId);
    if (section.classList.contains('collapsed1')) {
        section.classList.remove('collapsed1');
        section.style.maxHeight = section.scrollHeight + 'px';
    } else {
        section.style.maxHeight = '0px';
        section.classList.add('collapsed1');
    }
}

function openModal1(storeId) {
    var modal = document.getElementById('deleteModal1');
    var storeIdField = document.getElementById('storeIdToDelete1');
    storeIdField.value = storeId;
    modal.style.display = 'block';
}

document.getElementById('closeModal1').onclick = function() {
    document.getElementById('deleteModal1').style.display = 'none';
};

document.getElementById('cancelDelete1').onclick = function() {
    document.getElementById('deleteModal1').style.display = 'none';
};

window.onclick = function(event) {
    if (event.target == document.getElementById('deleteModal1')) {
        document.getElementById('deleteModal1').style.display = 'none';
    }
};


function showRegisterForm1() {
    const registerForm = document.getElementById('registerForm1');
    registerForm.style.display = 'block';
    setTimeout(() => {
        registerForm.style.opacity = '1';
    }, 50);
}
