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
            { "data": "email" },
            { "data": "phone", "orderable": false },
            { "data": "choose","orderable": false },
            { "data": "client_no","orderable": false },
            { "data": "agreement1", "orderable": false },
            { "data": "user_info", "orderable": false }
        ],
        "order": [[0, "asc"]]
    });
});