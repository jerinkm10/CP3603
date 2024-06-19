<!doctype html>
<html lang="en">
@include('pages.head')

<body>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="dashboard-cover">
            <div class="row">
                <div class="col-md-9">
                    <div class="dashboard-left admin1">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <hr>
                        <h5>Forms</h5>
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

    <!-- Fill Form Modal -->
    <div class="modal fade" id="fillFormModal" tabindex="-1" role="dialog" aria-labelledby="fillFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fillFormModalLabel">Fill Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="fillForm" action="{{ url('form/saveFormData') }}" method="POST">
                        @csrf
                        <input type="hidden" name="form_id" id="form_id">
                        <div id="dynamic-fields-container"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('pages.footer')

    <!-- jQuery, Popper.js, and Bootstrap JS -->

    <script>
    // Function to load forms from the backend
    function loadForms() {
    $.ajax({
        type: 'GET',
        url: '{{ route("form.getForms") }}',
        success: function(response) {
            var formsTable = $('#formsTable tbody');
            formsTable.empty();
            response.forms.forEach(function(form, index) {
                console.log("form_data",form.form_data.length)
                var fillFormButton = '';
                if (form.form_data.length > 0) {
                    fillFormButton = '<button class="btn btn-secondary" disabled>Form Already Filled</button>';
                    
                } else {
                    fillFormButton = '<button class="btn btn-primary fill-form" data-id="' + form.id + '">Fill Form</button>';
                }
                formsTable.append(
                    '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + form.name + '</td>' +
                    '<td>' + fillFormButton + '</td>' +
                    '</tr>'
                );
            });
        },
            error: function(xhr, status, error) {
                console.error('Error fetching forms:', xhr.responseText);
            }
        });
    }

    // Initial load of forms when the page loads
    $(document).ready(function() {
        loadForms();
    });
    $(document).ajaxComplete(function() {
        $(document).off('submit').on('submit', '#fillForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function(response) {
                    // Handle success response, e.g., close modal, refresh table, etc.
                    $('#fillFormModal').modal('hide');
                    loadForms(); // Reload forms after submission
                },
                error: function(xhr, status, error) {
                    console.error('Error submitting form:', xhr.responseText);
                    // Handle error response
                }
            });
        });
        $(document).off('click', '.fill-form');
        $(document).on('click', '.fill-form', function() {

            var formId = $(this).data('id');

            // Perform AJAX request to fetch form data
            $.ajax({
                type: 'GET',
                url: '/form/getFilForm/' + formId, // Adjust the URL as per your Laravel route
                success: function(response) {
                    // Assuming response contains form data, update modal fields
                    $('#form_id').val(formId); // Set form_id in the hidden input
                    console.log("response", response);

                    // Update modal fields based on fetched form data
                    $('#dynamic-fields-container').empty(); // Clear existing fields

                    // Loop through fields and add them to the modal
                    response.form.fields.forEach(function(field) {
                        var fieldHtml = '';

                        switch (field.input_type) {
                            case 'text':
                                fieldHtml = '<div class="form-group">' +
                                    '<label for="field_' + field.id + '">' + field
                                    .label + '</label>' +
                                    '<input type="' + field.input_type +
                                    '" class="form-control" id="field_' + field.id +
                                    '" name="fields[' + field.id + ']" required>' +
                                    '</div>';
                                console.log("text")
                                break;
                            case 'textarea':
                                fieldHtml = '<div class="form-group">' +
                                    '<label for="field_' + field.id + '">' + field
                                    .label + '</label>' +
                                    '<input type="' + field.input_type +
                                    '" class="form-control" id="field_' + field.id +
                                    '" name="fields[' + field.id + ']" required>' +
                                    '</div>';
                                console.log("text")
                                break;
                            case 'number':
                                fieldHtml = '<div class="form-group">' +
                                    '<label for="field_' + field.id + '">' + field
                                    .label + '</label>' +
                                    '<input type="' + field.input_type +
                                    '" class="form-control" id="field_' + field.id +
                                    '" name="fields[' + field.id + ']" required>' +
                                    '</div>';
                                break;
                            case 'textarea':
                                fieldHtml = '<div class="form-group">' +
                                    '<label for="field_' + field.id + '">' + field
                                    .label + '</label>' +
                                    '<textarea class="form-control" id="field_' +
                                    field.id + '" name="fields[' + field.id +
                                    ']" required></textarea>' +
                                    '</div>';
                                break;
                            case 'select':
                                var sanitizedInput = field.input_type_options
                                    .replace(/^""|""$/g, '').replace(/^\s*{/, '{')
                                    .replace(/}\s*$/, '}');

                                console.log("Sanitized Input:", sanitizedInput);

                                // Transform the sanitized input string to a JSON array format
                                var transformedString = sanitizedInput
                                    .replace('{', '["')
                                    .replace('"[', '[')
                                    .replace('}', '"]')
                                    .replace(/,\s*/g, '", "').replace(']"', ']');

                                console.log("Transformed String:",
                                    transformedString);

                                // Parse the transformed string to a JavaScript array
                                try {
                                    options = JSON.parse(transformedString);

                                    // Ensure options is an array
                                    if (!Array.isArray(options)) {
                                        options = [];
                                    }
                                } catch (e) {
                                    console.error(
                                        "Error parsing transformed string:", e);
                                    options = [];
                                }
                                fieldHtml = '<div class="form-group">' +
                                    '<label for="field_' + field.id + '">' + field
                                    .label + '</label>' +
                                    '<select class="form-control" id="field_' +
                                    field.id + '" name="fields[' + field.id +
                                    ']" required>';
                                options.forEach(function(option) {
                                    fieldHtml += '<option value="' +
                                        option + '">' + option +
                                        '</option>';
                                });
                                fieldHtml += '</select></div>';
                                break;
                            case 'checkbox':
                                var options;
                                console.log("input_type_options", field
                                    .input_type_options);

                                // Remove the extra quotes
                                var sanitizedInput = field.input_type_options
                                    .replace(/^""|""$/g, '').replace(/^\s*{/, '{')
                                    .replace(/}\s*$/, '}');

                                console.log("Sanitized Input:", sanitizedInput);

                                // Transform the sanitized input string to a JSON array format
                                var transformedString = sanitizedInput
                                    .replace('{', '["')
                                    .replace('"[', '[')
                                    .replace('}', '"]')
                                    .replace(/,\s*/g, '", "').replace(']"', ']');

                                console.log("Transformed String:",
                                    transformedString);

                                // Parse the transformed string to a JavaScript array
                                try {
                                    options = JSON.parse(transformedString);

                                    // Ensure options is an array
                                    if (!Array.isArray(options)) {
                                        options = [];
                                    }
                                } catch (e) {
                                    console.error(
                                        "Error parsing transformed string:", e);
                                    options = [];
                                }

                                var fieldHtml = '<div class="form-group">' +
                                    '<label>' + field.label + '</label>';

                                if (options.length) {
                                    options.forEach(function(option) {
                                        fieldHtml +=
                                            '<div class="form-check">' +
                                            '<input class="form-check-input" type="checkbox" id="field_' +
                                            field.id + '_' + option +
                                            '" name="fields[' + field.id +
                                            '][]" value="' + option + '">' +
                                            '<label class="form-check-label" for="field_' +
                                            field.id + '_' + option + '">' +
                                            option + '</label>' +
                                            '</div>';
                                    });
                                }

                                fieldHtml += '</div>';
                                break;
                            case 'radio':
                                var sanitizedInput = field.input_type_options
                                    .replace(/^""|""$/g, '').replace(/^\s*{/, '{')
                                    .replace(/}\s*$/, '}');

                                console.log("Sanitized Input:", sanitizedInput);

                                // Transform the sanitized input string to a JSON array format
                                var transformedString = sanitizedInput
                                    .replace('{', '["')
                                    .replace('"[', '[')
                                    .replace('}', '"]')
                                    .replace(/,\s*/g, '", "').replace(']"', ']');

                                console.log("Transformed String:",
                                    transformedString);

                                // Parse the transformed string to a JavaScript array
                                try {
                                    options = JSON.parse(transformedString);

                                    // Ensure options is an array
                                    if (!Array.isArray(options)) {
                                        options = [];
                                    }
                                } catch (e) {
                                    console.error(
                                        "Error parsing transformed string:", e);
                                    options = [];
                                }
                                fieldHtml = '<div class="form-group">' +
                                    '<label>' + field.label + '</label>';
                                if (options.length) {
                                    options.forEach(function(option) {
                                        fieldHtml +=
                                            '<div class="form-check">' +
                                            '<input class="form-check-input" type="radio" id="field_' +
                                            field.id + '_' + option +
                                            '" name="fields[' + field.id +
                                            ']" value="' + option + '">' +
                                            '<label class="form-check-label" for="field_' +
                                            field.id + '_' + option + '">' +
                                            option + '</label>' +
                                            '</div>';
                                    });
                                }
                                fieldHtml += '</div>';
                                break;
                            default:
                                fieldHtml = '<div class="form-group">' +
                                    '<label for="field_' + field.id + '">' + field
                                    .label + '</label>' +
                                    '<input type="text" class="form-control" id="field_' +
                                    field.id + '" name="fields[' + field.id +
                                    ']" required>' +
                                    '</div>';
                                break;
                        }

                        $('#dynamic-fields-container').append(fieldHtml);
                    });

                    // Open the fill form modal (assuming its ID is fillFormModal)
                    $('#fillFormModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching form data:', xhr.responseText);
                    // Handle error response
                }
            });



            // Function to handle form submission (for both add and edit forms)
            $(document).on('submit', '#fillForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    success: function(response) {
                        // Handle success response, e.g., close modal, refresh table, etc.
                        $('#fillFormModal').modal('hide');
                        loadForms(); // Reload forms after submission
                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting form:', xhr.responseText);
                        // Handle error response
                    }
                });
            });
        });
    });
    </script>

</body>

</html>