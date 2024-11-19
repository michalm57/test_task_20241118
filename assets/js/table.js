$(function() {
    $('#users-table').DataTable({
        "processing": true,
        "serverSide": true,
        "language": {
            "search": "Szukaj:",
            "lengthMenu": "Pokaż _MENU_ wpisów",
            "info": "Wyświetlanie _START_ do _END_ z _TOTAL_ wpisów",
            "infoEmpty": "Wyświetlanie 0 do 0 z 0 wpisów",
            "zeroRecords": "Brak pasujących wpisów",
            "emptyTable": "Brak danych w tabeli",
            "paginate": {
                "first": "Pierwsza",
                "previous": "Poprzednia",
                "next": "Następna",
                "last": "Ostatnia"
            },
        },
        "ajax": {
            "url": $('#users-table').attr('data-source-url'),
            "type": "GET"
        },
        "columns": [
            { "data": "name" },
            { "data": "surname" },
            { "data": "email", "orderable": false },
            { "data": "phone", "orderable": false },
            { "data": "client_no", "orderable": false },
            { 
                "data": "date", 
                "render": function(data, type, row) {
                    return moment.utc(data).local().format('YYYY-MM-DD HH:mm:ss');
                }
            }
        ],
        "order": [[5, "desc"]]
    });
});
