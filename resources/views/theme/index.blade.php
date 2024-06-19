<!doctype html>
<html lang="en">
@include('pages.head')

<body>
    @include('pages.header')
    @include('pages.sidebar')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="dash-head-main">Form Dashboard</h1>
        </div>
        <div class="dashboard-cover">
            <div class="row">
                <div class="col-md-9">
                    <div class="dashboard-left admin1">
                        <hr>
                        <h5>Forms</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dash-card">
                                    <a data-toggle="modal" data-target="#addFormModal"><i class="fa fa-plus"></i> Add
                                        Form</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <table id="formsTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Form Modal -->
    <div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="addFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFormModalLabel">Add Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{ route('form.saveForm') }}" method="POST">
                        @csrf
                        <input type="text" class="form-control" name="form_name" value="Sample Form Name">
                        <input type="hidden" name="rows" id="rows" value="0">

                        <table id="dynamic-table" class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Input Type</th>
                                    <th>Options</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="label[]" required /></td>
                                    <td>
                                        <select class="form-control inputType" name="inputType[]" required>
                                            <option value="">Select Input Type</option>
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                            <option value="select">Select Option</option>
                                            <option value="checkbox">Check Box</option>
                                            <option value="radioButton">Radio Button</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control inputTypeOption hide" name="inputTypeOption[]"
                                            multiple>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-success add-row">+</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Options Modal -->
    <div class="modal fade" id="optionsModal" tabindex="-1" role="dialog" aria-labelledby="optionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="optionsModalLabel">Enter Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="optionsForm">
                        <div id="optionsContainer">
                            <div class="form-group">
                                <label for="option">Option 1:</label>
                                <input type="text" class="form-control option-input" name="options[]" />
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="addOption">Add Another Option</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveOptions">Save Options</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form Modal (similar to Add Form Modal, but pre-populated with form data) -->
    <div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="editFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFormModalLabel">Edit Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('form.updateForm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="form_id" id="editFormId">
                        <input type="hidden" name="Editrow" id="Editrow" value="-1">
                        <table id="edit-dynamic-table" class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Input Type</th>
                                    <th>Options</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Existing form fields will be dynamically inserted here -->
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Options Modal -->
    <div class="modal fade" id="editOptionsModal" tabindex="-1" role="dialog" aria-labelledby="editOptionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOptionsModalLabel">Enter Edit Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="optionsForm">
                        <div id="editOptionsContainer">
                            <div class="form-group">
                                <label for="option">Option 1:</label>
                                <input type="text" class="form-control option-input" name="editoptions[]" />
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="editaddOption">Add Another Option</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editsaveOptions">Save Options</button>
                </div>
            </div>
        </div>
    </div>

    @include('pages.footer')

    <!-- jQuery, Popper.js, and Bootstrap JS -->

    <script>
    $(document).ready(function() {
        // Add Row Button Click Event with Validation
        function updateRowCount() {
            var rowCount = $('#dynamic-table tbody tr').length;
            return rowCount;
        }

        function rowCount() {
            var rowCount = parseInt($('#rows').val(), 10) || 0; // Ensure rowCount is an integer
            rowCount++; // Increment rowCount
            $('#rows').val(rowCount); // Update the input field with the new rowCount
            return rowCount;
        }


        $('#dynamic-table').on('click', '.add-row', function() {
            var isValid = true;

            // Validate each input field
            $('#dynamic-table input[required], #dynamic-table select[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validate each inputTypeOption field
            $('#dynamic-table .inputType').each(function() {
                var row = $(this).closest('tr');
                var inputTypeOption = row.find('.inputTypeOption');
                if ($(this).val() === 'select' || $(this).val() === 'checkbox' || $(this)
                    .val() === 'radioButton') {
                    if (inputTypeOption.children('option').length === 0) {
                        isValid = false;
                        alert('Please add at least one option.');
                    }
                }
            });

            // Add new row if all inputs are valid
            if (isValid) {
                var newRow = '<tr>' +
                    '<td><input type="text" class="form-control" name="label[]" required /></td>' +
                    '<td>' +
                    '<select class="form-control inputType" name="inputType[]" required>' +
                    '<option value="">Select Input Type</option>' +
                    '<option value="text">Text</option>' +
                    '<option value="textArea">Text Area</option>' +
                    '<option value="number">Number</option>' +
                    '<option value="select">Select Option</option>' +
                    '<option value="checkbox">Check Box</option>' +
                    '<option value="radioButton">Radio Button</option>' +
                    '</select>' +
                    '</td>' +
                    '<td>' +
                    '<select class="form-control inputTypeOption hide" name="inputTypeOption[' +
                    rowCount() + ']" multiple>' +
                    '</select>' +
                    '</td>' +
                    '<td><button type="button" class="btn btn-success add-row">+</button><button type="button" class="btn btn-danger remove-row">-</button></td>' +
                    '</tr>';

                $('#dynamic-table tbody').append(newRow);
            }
        });

        // Remove Row Button Click Event
        $('#dynamic-table').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        // Show options modal when "Select" is chosen
        $('#dynamic-table').on('change', '.inputType', function() {
            var row = $(this).closest('tr');
            var inputTypeOption = row.find('.inputTypeOption');

            // Clear the inputTypeOption select element
            inputTypeOption.empty().addClass('hide');

            if ($(this).val() === 'select' || $(this).val() === 'checkbox' || $(this).val() ===
                'radioButton') {
                $('#optionsModal').data('row', row).modal('show');
            }
        });

        // Add another option input in the modal
        var optionCount = 1;
        $('#addOption').click(function() {
            optionCount++;
            var newOption = '<div class="form-group">' +
                '<label for="option">Option ' + optionCount + ':</label>' +
                '<input type="text" class="form-control option-input" name="options[]" />' +
                '</div>';
            $('#optionsContainer').append(newOption);
        });

        // Save options and close the modal
        $('#saveOptions').click(function() {
            var options = [];
            $('.option-input').each(function() {
                if ($(this).val() !== '') {
                    options.push($(this).val());
                }
            });

            if (options.length > 0) {
                var row = $('#optionsModal').data('row');
                var select = row.find('.inputTypeOption');
                select.empty();
                $.each(options, function(index, value) {
                    select.append('<option value="' + value + '">' + value + '</option>');
                });
                select.removeClass('hide');
                $('#optionsModal').modal('hide');
            } else {
                alert('Please enter at least one option.');
            }
        });

        // Clear the options form when the modal is closed
        $('#optionsModal').on('hidden.bs.modal', function() {
            $('#optionsForm')[0].reset();
            $('#optionsContainer').html('<div class="form-group">' +
                '<label for="option">Option 1:</label>' +
                '<input type="text" class="form-control option-input" name="options[]" />' +
                '</div>');
            optionCount = 1;
        });

        // Reset the options form when the modal is opened
        $('#optionsModal').on('show.bs.modal', function() {
            $('#optionsForm')[0].reset();
            $('#optionsContainer').html('<div class="form-group">' +
                '<label for="option">Option 1:</label>' +
                '<input type="text" class="form-control option-input" name="options[]" />' +
                '</div>');
            optionCount = 1;
        });
        $('#addForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize form data
            var formData = $(this)
        .serializeArray(); // Use serializeArray() to get form data as array of objects

            // Collect inputTypeOption values manually
            $('.inputTypeOption').each(function() {
                var selectName = $(this).attr(
                'name'); // Get the name attribute of the select element
                var options = $(this).find('option').map(function() {
                    return $(this).text();
                }).get(); // Get an array of option texts

                if (options.length > 0) {
                    formData.push({
                        name: selectName,
                        value: '{' + options.join(', ') + '}'
                    }); // Push the grouped options into formData
                }
            });

            // Submit form data using AJAX
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $.param(
                formData), // Use formData which contains both form fields and options
                success: function(response) {
                    // On success, show SweetAlert success message
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to dashboard
                                window.location.href =
                                    'http://127.0.0.1:8000/dashboard';
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // On error, show SweetAlert error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error saving form. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error(xhr.responseText);
                }
            });
        });

       


        loadForms();
    });
    function loadForms() {
            $.ajax({
                type: 'GET',
                url: '{{ route("form.getForms") }}',
                success: function(response) {
                    var formsTable = $('#formsTable tbody');
                    formsTable.empty();
                    let i = 1;
                    response.forms.forEach(function(form) {
                        formsTable.append(
                            '<tr>' +
                            '<td>' + i + '</td>' +
                            '<td>' + form.name + '</td>' +
                            '<td>' +
                            '<button class="btn btn-primary edit-form" data-id="' + form
                            .id + '">Edit</button> ' +
                            '<button class="btn btn-danger delete-form" data-id="' +
                            form.id + '">Delete</button>' +
                            '</td>' +
                            '</tr>'
                        );
                        i++;
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching forms:', xhr.responseText);
                }
            });
        }
    $(document).ajaxComplete(function() {
        $(document).off('click', '.edit-form');
        $(document).on('click', '.edit-form', function() {
            var formId = $(this).data('id');
            console.log("formId", formId);
            $('#Editrow').val(-1);
            $.ajax({
                type: 'GET',
                url: '{{ url("form/getForm") }}/' + formId,
                success: function(response) {
                    $('#editFormId').val(response.form.id);
                    populateEditForm(response.form);
                    $('#editFormModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching form:', xhr.responseText);
                }
            });
        });

        $('#editForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            var formData = getSerializedFormData($(this));
            console.log("formData", formData);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $.param(formData),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editFormModal').modal('hide');
                                loadForms();
                            }
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error saving form. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).off('click', '.delete-form');
        $(document).on('click', '.delete-form', function() {
            var formId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ url("form/deleteForm") }}/' + formId,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                loadForms();
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Error deleting form. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

        // Event delegation for dynamically added elements
        $(document).off('click', '.edit-row').on('click', '.edit-row', function() {
            var isValid = true;
            
            // Validate each input field
            $('#edit-dynamic-table input[required], #edit-dynamic-table select[required]').each(
                function() {
                    if ($(this).val() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

            // Validate each editinputTypeOption field
            $('#edit-dynamic-table .editinputType').each(function() {
                var row = $(this).closest('tr');
                var inputTypeOption = row.find('.editinputTypeOption');
                if ($(this).val() === 'select' || $(this).val() === 'checkbox' || $(this)
                    .val() === 'radioButton') {
                    if (inputTypeOption.children('option').length === 0) {
                        isValid = false;
                        alert('Please add at least one option.');
                    }
                }
            });

            // Add new row if all inputs are valid
            if (isValid) {
                var newRow = '<tr>' +
                    '<td><input type="text" class="form-control" name="editlabel[]" required /></td>' +
                    '<td>' +
                    '<select class="form-control editinputType" name="editinputType[]" required>' +
                    '<option value="">Select Input Type</option>' +
                    '<option value="text">Text</option>' +
                    '<option value="textArea">Text Area</option>' +
                    '<option value="number">Number</option>' +
                    '<option value="select">Select Option</option>' +
                    '<option value="checkbox">Check Box</option>' +
                    '<option value="radioButton">Radio Button</option>' +
                    '</select>' +
                    '</td>' +
                    '<td>' +
                    '<select class="form-control editinputTypeOption hide" name="editinputTypeOption[' +
                    editRowCount() + ']" multiple>' +
                    '</select>' +
                    '</td>' +
                    '<td><button type="button" class="btn btn-success edit-row">+</button><button type="button" class="btn btn-danger edit-remove-row">-</button></td>' +
                    '</tr>';

                $('#edit-dynamic-table tbody').append(newRow);
            }
        });
        // $(document).off('click', '.edit-row').on('click', '.edit-row', function() {
        //     var row = $(this).closest('tr').clone();
        //     row.find('input, select, select:multiple').val(''); // Clear input values
        //     $(this).closest('tr').after(row);
        // });
        // Save options and close the modal
        $(document).off('click', '#editsaveOptions').on('click', '#editsaveOptions', function() {
            var options = [];
            $('#editOptionsModal .option-input').each(function() {
                if ($(this).val() !== '') {
                    options.push($(this).val());
                }
            });

            if (options.length > 0) {
                var row = $('#editOptionsModal').data('row');
                var select = row.find('.editinputTypeOption');
                select.empty();
                $.each(options, function(index, value) {
                    select.append('<option value="' + value + '">' + value + '</option>');
                });
                select.removeClass('hide');
                $('#editOptionsModal').modal('hide');
            } else {
                alert('Please enter at least one option.');
            }
        });
        $(document).off('click', '.edit-remove-row').on('click', '.edit-remove-row', function() {
            if ($('#edit-dynamic-table tbody tr').length > 1) {
                $(this).closest('tr').remove();
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'At least one field is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
    // Add another option input in the modal
    var optionCount = 1;
    $(document).off('click', '#editaddOption').on('click', '#editaddOption', function() {
        optionCount++;
        var newOption = '<div class="form-group">' +
            '<label for="option">Option ' + optionCount + ':</label>' +
            '<input type="text" class="form-control option-input" name="EditOptions[]" />' +
            '</div>';
        $('#editOptionsContainer').append(newOption);
    });

    $('#edit-dynamic-table').on('change', '.editinputType', function() {
        var row = $(this).closest('tr');
        var inputTypeOption = row.find('.editinputTypeOption');

        // Clear the inputTypeOption select element
        inputTypeOption.empty().addClass('hide');

        if ($(this).val() === 'select' || $(this).val() === 'checkbox' || $(this).val() ===
            'radioButton') {
            $('#editOptionsModal').data('row', row).modal('show');
        }
    });

    function editRowCount() {
        var rowCount = parseInt($('#Editrow').val(), 10) || 0; // Ensure rowCount is an integer
        console.log("rowCount",rowCount);
        rowCount++; 
       // Increment rowCount
        $('#Editrow').val(rowCount); 
       // Update the input field with the new rowCount
        
       
        return rowCount;
    }

    function populateEditForm(form) {
        var editTableBody = $('#edit-dynamic-table tbody');
        editTableBody.empty();
        form.fields.forEach(function(field, index) {
            var options = '';
            if (field.input_type_options) {
                var optionsArray = JSON.parse(field.input_type_options).replace(/[{}]/g, '').split(',').map(
                    function(option) {
                        return option.trim();
                    });
                if (Array.isArray(optionsArray)) {
                    optionsArray.forEach(function(option) {
                        options += '<option value="' + option + '" selected>' + option + '</option>';
                    });
                } else {
                    options = '<option value="' + field.input_type_options + '" selected>' + field
                        .input_type_options + '</option>';
                }
            }
            editTableBody.append(
                '<tr>' +
                '<td><input type="text" class="form-control" name="editlabel[]" value="' + field.label +
                '" required /></td>' +
                '<td>' +
                '<select class="form-control editinputType" name="editinputType[]" required>' +
                '<option value="text"' + (field.input_type === 'text' ? ' selected' : '') +
                '>Text</option>' +
                '<option value="textArea"' + (field.input_type === 'textArea' ? ' selected' : '') +
                '>Text Area</option>' +
                '<option value="number"' + (field.input_type === 'number' ? ' selected' : '') +
                '>Number</option>' +
                '<option value="select"' + (field.input_type === 'select' ? ' selected' : '') +
                '>Select Option</option>' +
                '<option value="checkbox"' + (field.input_type === 'checkbox' ? ' selected' : '') +
                '>Check Box</option>' +
                '<option value="radioButton"' + (field.input_type === 'radioButton' ? ' selected' : '') +
                '>Radio Button</option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="form-control editinputTypeOption" name="editinputTypeOption[' +
                editRowCount() + ']" multiple>' +
                options +
                '</select>' +
                '</td>' +
                '<td><button type="button" class="btn btn-success edit-row">+</button><button type="button" class="btn btn-danger edit-remove-row">-</button></td>' +
                '</tr>'
            );
        });
    }

    function getSerializedFormData(form) {
        var formData = form.serializeArray();
        formData = formData.filter(function(item) {
            return !item.name.startsWith('editinputTypeOption');
        });
        $('.editinputTypeOption').each(function() {
            var selectName = $(this).attr('name');
            var options = $(this).find('option').map(function() {
                return $(this).text();
            }).get();
            if (options.length > 0) {
                formData.push({
                    name: selectName,
                    value: '{' + options.join(', ') + '}'
                });
            }
        });
        return formData;
    }
    </script>

</body>

</html>