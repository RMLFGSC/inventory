<!--datatables cdn bootrap and js-->
<script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.0/js/dataTables.bootstrap5.min.js"></script>


<!--script for table-->
<script>
    $(document).ready(function() {
    $('#dataTable').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 20, 30, 40, -1],
            [10, 20, 30, 40, "All"]
        ],
        "order": [], // 🚀 This disables automatic sorting
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search here yot...",
        }
    });
});
</script>


