
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suppliers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="supplier_table" class="table table-light table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>User</th>
                                <th>Edit/Delete</th>
                            </tr>    
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button class="btn btn-dark" onclick="addSupplier()" type="button">Add Supplier</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>

    let supplier_datatable;

    function deleteSupplier(supplier_id)
    {
        var html = `<div>
                        <p>Do you want to delete the selected supplier ?.</p>
                    </div>
                    <div>
                        <hr class="my-3"/>
                        <button class="btn btn-secondary" type="button" onclick="bootbox.hideAll();">Cancel</button>
                        <button class="btn btn-danger" type="button" onclick="_deleteSupplierSubmit(${supplier_id})">Delete Supplier</button>
                    </div>`;

        let dialog = bootbox.dialog({
            title: '<span class="display-5">Delete Supplier</span>',
            message: html,
            size: 'large'
        });
    }

    async function _deleteSupplierSubmit(supplier_id)
    {
        clearErrors();

        const response_json = await fetch("/supplier-delete/" + supplier_id, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }                            
        });
        const response = await response_json.json();
        if (response.errors != undefined) {
            displayErrors(response);            
        }  else if (response.status == 'success') {
            bootbox.hideAll();
            supplier_datatable.ajax.reload();
        } 
    }

    function editSupplier(supplier_id)
    {
        let data = JSON.parse($('#span-supplier-data-' + supplier_id).html());

        var html = `<div>
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="${data.name}" id="supplier_name" placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">Address</label>
                            <textarea class="form-control" id="supplier_address" rows="3">${data.address}</textarea>
                        </div>
                    </div>
                    <div>
                        <hr class="my-3"/>
                        <button class="btn btn-secondary" type="button" onclick="bootbox.hideAll();">Cancel</button>
                        <button class="btn btn-dark" type="button" onclick="_editSupplierSubmit(${supplier_id})">Update Supplier</button>
                    </div>`;
        let dialog = bootbox.dialog({
            title: '<span class="display-5">Edit Supplier</span>',
            message: html,
            size: 'large'
        });
    }

    async function _editSupplierSubmit(supplier_id)
    {
        clearErrors();

        const response_json = await fetch("/supplier-update/" + supplier_id, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                "name": $('#supplier_name').val(),
                "address": $('#supplier_address').val()
            }),                            
        });
        const response = await response_json.json();
        if (response.errors != undefined) {
            displayErrors(response);            
        }  else if (response.status == 'success') {
            bootbox.hideAll();
            supplier_datatable.ajax.reload();
        } 
    }
    
    function addSupplier()
    {
        var html = `<div>
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="supplier_name" placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">Address</label>
                            <textarea class="form-control" id="supplier_address" rows="3"></textarea>
                        </div>
                    </div>
                    <div>
                        <hr class="my-3"/>
                        <button class="btn btn-secondary" type="button" onclick="bootbox.hideAll();">Cancel</button>
                        <button class="btn btn-dark" type="button" onclick="_addSupplierSubmit()">Add Supplier</button>
                    </div>
                    `;
        let dialog = bootbox.dialog({
            title: '<span class="display-5">Add New Supplier</span>',
            message: html,
            size: 'large'
        });
    }

    async function _addSupplierSubmit()
    {
        clearErrors();

        const response_json = await fetch("/supplier-add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                "name": $('#supplier_name').val(),
                "address": $('#supplier_address').val()
            }),                            
        });
                        
        const response = await response_json.json();
        if (response.errors != undefined) {
            displayErrors(response);            
        }  else if (response.status == 'success') {
            bootbox.hideAll();
            supplier_datatable.ajax.reload();
        }                     
    }

    function clearErrors()
    {
        $('.modal-dialog .modal-body .bootbox-body .errors_div').remove();
    }

    function displayErrors(data)
    {
        var errors_html = '<div class="errors_div text-danger text-center">';
        for (let ele in data.errors) {
            errors_html += '<div class="mb3">'
            errors_html += `<span class="fw-bold">${ele.toUpperCase()}</span>`
            for (let idx in data.errors[ele]) {
                errors_html += `<div>${data.errors[ele][idx]}</div>`;
            }            
            errors_html += '<div>'
        }
        errors_html += '</div>';

        $('.modal-dialog .modal-body .bootbox-body').prepend(errors_html);
    }

    $(document).ready(function() {        
        supplier_datatable = new DataTable('#supplier_table', {
            serverSide: false,
            ajax: {
                url: '/supplier-table-data',
                type: 'GET',                
                dataFilter: function(data) {
                    var json = jQuery.parseJSON( data );
                    let table_data = {};
                    table_data.recordsTotal = json.suppliers.recordsTotal;
                    table_data.recordsFiltered = json.suppliers.recordsTotal;
                    table_data.data = [];

                    for (let idx in json.suppliers.data) {

                        let supplier_id = json.suppliers.data[idx]['supplier_id'];
                        let edit_button = `<button class="btn btn-outline-secondary" onclick="editSupplier(${supplier_id})" type="button"><i class="fa-regular fa-pen-to-square"></i></button>`;    
                        let delete_button = `<button class="btn btn-outline-danger" onclick="deleteSupplier(${supplier_id})" type="button"><i class="fa-regular fa-trash-can"></i></button>`;
                        let group_button = `<div class="btn-group" role="group">${edit_button}${delete_button}</div>`; 
                        let span_data = `<span id="span-supplier-data-${supplier_id}" class="d-none">${JSON.stringify(json.suppliers.data[idx])}</span>`; 
                        table_data.data.push([
                            json.suppliers.data[idx]['index'],
                            json.suppliers.data[idx]['name'],
                            json.suppliers.data[idx]['address'],
                            json.suppliers.data[idx]['user'],
                            group_button + span_data
                        ]);
                    }
                    return JSON.stringify(table_data);
                },                
            },
            columnDefs: [
                { width: '5%', targets: [ 0 ] },
                { width: '20%', targets: [ 1 ] },
                { width: '40%', targets: [ 2 ] },
                { width: '20%', targets: [ 3 ] },
                { width: '15%', targets: [ 4 ] },
                { className: 'text-center', targets: '_all' },
                { "orderable": false, "targets": [0, 4] }
            ],
            paging: false,
        });
    });    
</script>    
