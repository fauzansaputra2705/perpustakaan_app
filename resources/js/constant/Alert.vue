<script>
import { useToast } from 'vue-toastification'
const toast = useToast()

export const Alert = (type, message) => {
    if (type == 'success') {
        toast.success(message, {
            position: 'top-right',
            timeout: 5000,
            closeOnClick: false,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: 'button',
            icon: true,
            rtl: false,
        })
    } else if (type == 'warning') {
        toast.warning(message, {
            position: 'top-right',
            timeout: 5000,
            closeOnClick: false,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: 'button',
            icon: true,
            rtl: false,
        })
    } else if (type == 'error') {
        toast.error(message, {
            position: 'top-right',
            timeout: 5000,
            closeOnClick: false,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: 'button',
            icon: true,
            rtl: false,
        })
    }
}
</script>
