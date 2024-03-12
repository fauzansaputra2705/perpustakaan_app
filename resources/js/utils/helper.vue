<script>
import { format } from 'date-fns'
import localeID from 'date-fns/locale/id'

export const isDateRange = (startDate, endDate) => {
    const currentDate = new Date()
    return currentDate >= startDate && currentDate <= endDate
}

export const formatDate = (date) => {
    return format(date, 'dd MMMM yyyy', { locale: localeID })
}
</script>
