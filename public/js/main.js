document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('loadDataButton').addEventListener('click', function () {
        fetch(URL_PUBLIC + '/api/data')
            .then(response => response.json())
            .then(data => {
                const dataContainer = document.getElementById('dataContainer');
                dataContainer.innerHTML = '';

                if (data.length === 0) {
                    dataContainer.innerHTML = '<div class="alert alert-warning" role="alert">No data found.</div>';
                    return;
                }

                const table = document.createElement('table');
                table.className = 'table table-bordered';
                const thead = document.createElement('thead');
                thead.innerHTML = '<tr><th>ID</th><th>Name</th></tr>';
                table.appendChild(thead);

                const tbody = document.createElement('tbody');

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${item.user_id}</td><td>${item.username}</td>`;
                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                dataContainer.appendChild(table);
            })
            .catch(error => console.error('Error:', error));
    });
});
