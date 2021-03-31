import Swal from 'sweetalert2'

export default class General {

    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        $("body").on('click', '.btn-delete', this, this.onDestroyRecordClick);
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
