import Swal from "sweetalert2";

export async function useSwal(message, type = 'success', position = 'center') {
    return await Swal.fire({
        position: position,
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
}

export async function useSuccessSwal(message, position = 'center') {
    return await Swal.fire({
        position: position,
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
}

export async function useConfirmSwal(title, message, confirmButton = 'delete') {
    return await Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#8C9173',
        confirmButtonText: trans('message.' + confirmButton),
        cancelButtonText: trans('message.cancel'),
    })
}

export async function useConfirmDeleteSwal(message) {
    return await Swal.fire({
        title: trans('message.warning'),
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#8C9173',
        confirmButtonText: trans('message.delete'),
        cancelButtonText: trans('message.cancel'),
    })
}

export async function useConfirmationSwal(message) {
    return await Swal.fire({
        title: trans('message.warning'),
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#8C9173',
        confirmButtonText: trans('message.confirm'),
        cancelButtonText: trans('message.cancel'),
    })
}

export async function useSwalDeleted(message){
    return await Swal.fire({
        title: trans('message.deleted'),
        text: message,
        icon: 'success',
        confirmButtonColor: '#8C9173',
        confirmButtonText: trans('message.ok'),
    })
}

export async function useSwalError(message){
    return await Swal.fire({
        title: trans('message.error'),
        text: message,
        icon: 'error',
        confirmButtonColor: '#8C9173',
        confirmButtonText: trans('message.ok'),
    })
}

export async function useSwalWarning(message){
    return await Swal.fire({
        text: message,
        icon: 'warning',
        confirmButtonColor: '#8C9173',
        confirmButtonText: trans('message.ok'),
    })
}

export async function useSwalAddressWarning(message){
    return await Swal.fire({
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#8C9173',
        cancelButtonText: trans('message.myAddresses'),
        confirmButtonText: trans('message.ok'),
    })
}

export async function useSwalTrans(message, type = 'success', position = 'center') {
    return await useSwal(trans(message), type, position);
}

export async function useConfirmSwalTrans(title, message, confirmButton= 'delete') {
    return await useConfirmSwal(trans(title), trans(message), confirmButton);
}
