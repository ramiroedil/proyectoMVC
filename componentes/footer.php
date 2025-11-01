</div>
</main>
<footer class="p-3 mt-auto">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 order-last order-md-first">
                <div class="copyright text-center my-auto">
                </div>
            </div>
            <div class="col-md-6">
                <div class="terms d-flex justify-content-center justify-content-md-end">
                    <a href="#0" class="text-sm">Term & Conditions</a>
                    <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
                </div>
            </div>
        </div>
</footer>
</body>

</html>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/dynamic-pie-chart.js"></script>
<script src="../assets/js/moment.min.js"></script>
<script src="../assets/js/fullcalendar.js"></script>
<script src="../assets/js/jvectormap.min.js"></script>
<script src="../assets/js/world-merc.js"></script>
<script src="../assets/js/polyfill.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/Chart.min.js"></script>
<script>
    // Exporta una tabla HTML a Excel
    function exportTableToExcel(tableID, filename) {
        // Tipo de exportación
        if (!filename) filename = 'excel_data.xls';
        let dataType = 'application/vnd.ms-excel';

        // Origen de los datos
        let tableSelect = document.getElementById(tableID);
        let tableHTML = tableSelect.outerHTML;
        // Crea el archivo descargable
        let blob = new Blob([tableHTML], {
            type: dataType
        });

        // Crea un enlace de descarga en el navegador
        if (window.navigator && window.navigator.msSaveOrOpenBlob) { // Descargar para IExplorer
            window.navigator.msSaveOrOpenBlob(blob, filename);
        } else { // Descargar para Chrome, Firefox, etc.
            let dataUrl = URL.createObjectURL(blob);
            let a = document.createElement("a");
            document.body.appendChild(a);
            a.download = filename;
            a.href = dataUrl;
            a.click();
            URL.revokeObjectURL(dataUrl);
            a.remove();
        }
    }
</script>