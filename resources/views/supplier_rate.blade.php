
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Supplier Rates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="supplier_rate_table" class="table table-light table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Supplier</th>
                                <th>Currency</th>
                                <th>Rate Start Date</th>
                                <th>Rate End Date</th>
                                <th>User</th>
                                <th>Edit/Delete</th>
                            </tr>    
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button class="btn btn-dark" onclick="addSupplierRate()" type="button">Add Supplier Rate</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>

    let supplier_rate_datatable;
    let supplier_list;

    function deleteSupplierRate(supplier_rate_id)
    {
        var html = `<div>
                        <p>Do you want to delete the selected supplier rate ?.</p>
                    </div>
                    <div>
                        <hr class="my-3"/>
                        <button class="btn btn-secondary" type="button" onclick="bootbox.hideAll();">Cancel</button>
                        <button class="btn btn-danger" type="button" onclick="_deleteSupplierRateSubmit(${supplier_rate_id})">Delete Supplier Rate</button>
                    </div>`;

        let dialog = bootbox.dialog({
            title: '<span class="display-5">Delete Supplier Rate</span>',
            message: html,
            size: 'large'
        });
    }

    async function _deleteSupplierRateSubmit(supplier_rate_id)
    {
        clearErrors();

        const response_json = await fetch("/supplier-rate-delete/" + supplier_rate_id, {
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
            supplier_rate_datatable.ajax.reload();
        } 
    }

    function editSupplierRate(supplier_rate_id)
    {
        let supplier_rate_data = JSON.parse($('#span-supplier-data-' + supplier_rate_id).html());
        let selected_supplier_id = supplier_rate_data.supplier.supplier_id;

        // supplier select options
        let suppliers_options = '';
        for(let supplier_id in supplier_list) {
            if (selected_supplier_id == supplier_id) {
                suppliers_options += `<option selected value="${supplier_id}">${supplier_list[supplier_id]}</option>`;
            } else {
                suppliers_options += `<option value="${supplier_id}">${supplier_list[supplier_id]}</option>`;
            }            
        }

        let html = `<div>
                        <div class="mb-3">
                            <label for="supplier" class="form-label">Supplier</label>
                            <select class="form-control" id="supplier">
                                ${suppliers_options}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <input type="text" class="form-control" id="currency" value="${supplier_rate_data.currency}" placeholder="Enter Currency">
                        </div>
                        <div class="mb-3">
                            <label for="rate_start_date" class="form-label">Rate Start Date</label>
                            <input type="text" class="form-control" id="rate_start_date" value="${supplier_rate_data.rate_start_date}" placeholder="Enter Rate Start Date">
                        </div>
                        <div class="mb-3">
                            <label for="rate_end_date" class="form-label">Rate End Date</label>
                            <input type="text" class="form-control" id="rate_end_date" value="${supplier_rate_data.rate_end_date}" placeholder="Enter Rate End Date">
                        </div>                        
                    </div>
                    <div>
                        <hr class="my-3"/>
                        <button class="btn btn-secondary" type="button" onclick="bootbox.hideAll();">Cancel</button>
                        <button class="btn btn-dark" type="button" onclick="_editSupplierRateSubmit(${supplier_rate_id})">Update Supplier Rate</button>
                    </div>`;

        let dialog = bootbox.dialog({
            title: '<span class="display-5">Edit Supplier Rate</span>',
            message: html,
            size: 'large',
            onShow: function(e) {
                let optional_config = {
                    dateFormat: "Y-m-d",
                };
                $("#rate_start_date").flatpickr(optional_config);
                $("#rate_end_date").flatpickr(optional_config);
            }
        });
    }

    async function _editSupplierRateSubmit(supplier_rate_id)
    {
        clearErrors();

        const response_json = await fetch("/supplier-rate-update/" + supplier_rate_id, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                "supplier": $('#supplier').val(),
                "currency": $('#currency').val(),
                "rate_start_date": $('#rate_start_date').val(),
                "rate_end_date": $('#rate_end_date').val()
            }),                            
        });
        const response = await response_json.json();
        if (response.errors != undefined) {
            displayErrors(response);            
        }  else if (response.status == 'success') {
            bootbox.hideAll();
            supplier_rate_datatable.ajax.reload();
        } 
    }

    function addSupplierRate()
    {
        let suppliers_options = '';
        for(let supplier_id in supplier_list) {
            suppliers_options += `<option value="${supplier_id}">${supplier_list[supplier_id]}</option>`;
        }

        let html = `<div>
                        <div class="mb-3">
                            <label for="supplier" class="form-label">Supplier</label>
                            <select class="form-control" id="supplier">
                                ${suppliers_options}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <input type="text" class="form-control" id="currency" placeholder="Enter Currency">
                        </div>
                        <div class="mb-3">
                            <label for="rate_start_date" class="form-label">Rate Start Date</label>
                            <input type="text" class="form-control" id="rate_start_date" placeholder="Enter Rate Start Date">
                        </div>
                        <div class="mb-3">
                            <label for="rate_end_date" class="form-label">Rate End Date</label>
                            <input type="text" class="form-control" id="rate_end_date" placeholder="Enter Rate End Date">
                        </div>                        
                    </div>
                    <div>
                        <hr class="my-3"/>
                        <button class="btn btn-secondary" type="button" onclick="bootbox.hideAll();">Cancel</button>
                        <button class="btn btn-dark" type="button" onclick="_addSupplierRateSubmit()">Add Supplier Rate</button>
                    </div>`;

        let dialog = bootbox.dialog({
            title: '<span class="display-5">Add New Supplier Rate</span>',
            message: html,
            size: 'large',
            onShow: function(e) {
                let optional_config = {
                    dateFormat: "Y-m-d",
                };
                $("#rate_start_date").flatpickr(optional_config);
                $("#rate_end_date").flatpickr(optional_config);
            }
        });
    }

    async function _addSupplierRateSubmit()
    {
        clearErrors();

        const response_json = await fetch("/supplier-rate-add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                "supplier": $('#supplier').val(),
                "currency": $('#currency').val(),
                "rate_start_date": $('#rate_start_date').val(),
                "rate_end_date": $('#rate_end_date').val()
            }),                            
        });
        const response = await response_json.json();
        if (response.errors != undefined) {
            displayErrors(response);            
        }  else if (response.status == 'success') {
            bootbox.hideAll();
            supplier_rate_datatable.ajax.reload();
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
        supplier_rate_datatable = new DataTable('#supplier_rate_table', {
            serverSide: false,
            ajax: {
                url: '/supplier-rate-table-data',
                type: 'GET',                
                dataFilter: function(data){
                    var json = jQuery.parseJSON( data );
                    let table_data = {};
                    table_data.recordsTotal = json.supplier_rates.recordsTotal;
                    table_data.recordsFiltered = json.supplier_rates.recordsTotal;
                    table_data.data = [];
                    supplier_list = json.supplier_list;

                    for (let idx in json.supplier_rates.data) {

                        let supplier_rate_id = json.supplier_rates.data[idx]['supplier_rate_id'];
                        let edit_button = `<button class="btn btn-outline-secondary" onclick="editSupplierRate(${supplier_rate_id})" type="button"><i class="fa-regular fa-pen-to-square"></i></button>`;    
                        let delete_button = `<button class="btn btn-outline-danger" onclick="deleteSupplierRate(${supplier_rate_id})" type="button"><i class="fa-regular fa-trash-can"></i></button>`;
                        let group_button = `<div class="btn-group" role="group">${edit_button}${delete_button}</div>`; 
                        let span_data = `<span id="span-supplier-data-${supplier_rate_id}" class="d-none">${JSON.stringify(json.supplier_rates.data[idx])}</span>`; 
                        let supplier_name = ''
                        if (json.supplier_rates.data[idx]['supplier'] != null) {
                            supplier_name = json.supplier_rates.data[idx]['supplier']['name']
                        }
                        table_data.data.push([
                            json.supplier_rates.data[idx]['index'],
                            supplier_name,
                            json.supplier_rates.data[idx]['currency'],
                            json.supplier_rates.data[idx]['rate_start_date'],
                            json.supplier_rates.data[idx]['rate_end_date'],
                            json.supplier_rates.data[idx]['user'],
                            group_button + span_data
                        ]);
                    }
                    return JSON.stringify(table_data);
                }
            },
            columnDefs: [
                { width: '5%', targets: [ 0 ] },
                { width: '25%', targets: [ 1 ] },
                { width: '10%', targets: [ 2 ] },
                { width: '15%', targets: [ 3 ] },
                { width: '15%', targets: [ 4 ] },
                { width: '15%', targets: [ 5 ] },
                { width: '15%', targets: [ 6 ] },
                { className: 'text-center', targets: '_all' },
                { "orderable": false, "targets": [0, 6] }                
            ],
            order: [[ 0, "asc" ]],
            paging: false,
        });
    });    
</script>    
