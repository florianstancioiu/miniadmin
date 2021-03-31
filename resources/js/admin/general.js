import Swal from 'sweetalert2';
import SimpleMDE from 'simplemde/dist/simplemde.min';

export default class General {

    constructor() {
        this.bindEvents();
        this.initMdEditor();
    }

    bindEvents() {
        $("body").on('click', '.btn-delete', this, this.onDestroyRecordClick);
    }

    initMdEditor() {
        if ($(".simplemde").length >= 1) {
            new SimpleMDE({ element: $(".simplemde")[0] });
        }
    }

    onDestroyRecordClick(event) {
        event.preventDefault();

        const $this = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $this.parents('form').trigger('submit');
            }
        })
    }
}

const general = new General();
