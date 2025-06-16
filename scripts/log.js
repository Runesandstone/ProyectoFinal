// scripts/log.js
document.addEventListener('DOMContentLoaded', function() {
    const logContentDiv = document.getElementById('logContent');
    const clearLogButton = document.getElementById('clearLogButton'); // Correct button ID

    if (!logContentDiv) {
        console.error("Error: 'logContent' div not found.");
        return;
    }

    // Function to fetch and display log data (from previous examples)
    function fetchAndDisplayLog() {
        logContentDiv.innerHTML = '<p class="no-log-message">Cargando log de actividad...</p>';

        fetch('php/get_admin_log.php') // This fetches the log data
            .then(response => {
                if (!response.ok) {
                    if (response.status === 403) {
                        return response.json().then(err => { throw new Error(err.error || 'Acceso denegado al log.'); });
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(logData => {
                if (logData.error) {
                    logContentDiv.innerHTML = `<p class="log-error-message">Error: ${logData.error}</p>`;
                    console.error("Server error:", logData.error);
                    return;
                }

                if (logData.length === 0) {
                    logContentDiv.innerHTML = '<p class="no-log-message">No hay entradas en el log.</p>';
                    return;
                }

                const table = document.createElement('table');
                table.className = 'log-table';

                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                const columnNames = Object.keys(logData[0]);
                columnNames.forEach(colName => {
                    const th = document.createElement('th');
                    th.textContent = colName.replace(/_/g, ' ').toUpperCase();
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                const tbody = document.createElement('tbody');
                logData.forEach(entry => {
                    const row = document.createElement('tr');
                    columnNames.forEach(colName => {
                        const td = document.createElement('td');
                        td.textContent = entry[colName];
                        row.appendChild(td);
                    });
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);

                logContentDiv.innerHTML = '';
                logContentDiv.appendChild(table);
            })
            .catch(error => {
                console.error('Error al cargar el log:', error);
                logContentDiv.innerHTML = `<p class="log-error-message">Error al cargar el log: ${error.message || error}.</p>`;
            });
    }

    // --- Clear log button functionality ---
    if (clearLogButton) {
        clearLogButton.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres borrar el log de actividad? Esta acción no se puede deshacer.')) {
                // Display a temporary message while clearing
                logContentDiv.innerHTML = '<p class="no-log-message">Limpiando log de actividad...</p>';

                fetch('php/clean_admin_log.php', { // Corrected PHP filename
                    method: 'POST', // Use POST for actions that modify data
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({}) 
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        logContentDiv.innerHTML = `<p class="no-log-message success">${data.message || 'Log de actividad borrado con éxito.'}</p>`;
                        // Optionally refresh the log content after a short delay
                        setTimeout(fetchAndDisplayLog, 1500); // Re-fetch logs after 1.5 seconds
                    } else {
                        logContentDiv.innerHTML = `<p class="log-error-message">Error al borrar el log: ${data.error || 'Error desconocido.'}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error al borrar el log:', error);
                    logContentDiv.innerHTML = `<p class="log-error-message">Error de red al borrar el log: ${error.message || error}.</p>`;
                });
            }
        });
    }

    // Initial load of log data when the page loads
    fetchAndDisplayLog();
});