'use strict';

$(tableName).DataTable({
    ajax: {
        url: indexUrl,
    },
});

$(document).on('submit', createFormId, function (e) {
    let formId = '#' + $(this).attr('id');
    e.preventDefault();
    processingBtn(formId, '#btnSave', 'loading');
    let url = $(this).attr('action');
    let data = $(this).serialize();
    submitForm(url, 'POST', data, formId, createModelId, tableName);
});

$(document).on('submit', editFormId, function (e) {
    e.preventDefault();
    let formId = '#' + $(this).attr('id');
    processingBtn(formId, '#btnSave', 'loading');
    const id = $('#editId').val();
    let url = indexUrl + id;
    let data = $(this).serialize();
    submitForm(url, 'PUT', data, formId, editModelId, tableName);
});

$(document).on('click', editButtonSelector, function (event) {
    let id = $(event.currentTarget).data('id');
    renderData(id);
});

window.renderData = function (id) {
    $.ajax({
        url: indexUrl + id + '/edit',
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let data = result.data;
                $('#editId').val(data.id);
                fillEditDataWithKeys(data, editFormId);
                $(editModelId).appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
};

$(document).on('click', showButtonSelector, function (event) {
    let id = $(event.currentTarget).data('id');
    $.ajax({
        url: indexUrl + id,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                let data = result.data;
                showModelData(data);
                $(showModelId).appendTo('body').modal('show');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

$(document).on('click', deleteButtonSelector, function (event) {
    let Id = $(event.currentTarget).data('id');
    let deleteUrl = indexUrl + Id;
    deleteItem(deleteUrl, tableName, 'Demo');
});

$(createModelId).on('hidden.bs.modal', function () {
    resetModalForm(createFormId);
});

$(editModelId).on('hidden.bs.modal', function () {
    resetModalForm(editFormId);
});
