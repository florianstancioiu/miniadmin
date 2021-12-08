import Swal from 'sweetalert2';
import EasyMDE from 'easymde/dist/easymde.min';

export default class General {

    constructor() {
        this.bindEvents();
        this.initMdEditor();
        this.initTooltips();
    }

    bindEvents() {
        $("body").on('click', '.btn-delete', this, this.onDestroyRecordClick);
    }

    initMdEditor() {
        if ($(".easymde").length >= 1) {
            // create a global instance so that I can access it inside the browser tests
            // to set values when creating posts or pages
            window.EasyMDEInstance = new EasyMDE({ element: $(".easymde")[0] });
        }
    }

    initTooltips() {
        jQuery('[data-toggle="tooltip"]').tooltip()
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
