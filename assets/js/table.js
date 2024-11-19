$(function() {
    $('#users-table').DataTable({
        "processing": true,
        "serverSide": true,
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