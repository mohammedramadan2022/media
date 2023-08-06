export function getCurrentStatus(status) {
    if(status === 'pending') return trans('message.pending');
    else if(status === 'rejected') return trans('message.rejected');
    else if(status === 'accepted') return trans('message.accepted');
    else if(status === 'returns') return trans('message.returns');
    else if(status === 'processing') return trans('message.processing');
    else if(status === 'processed') return trans('message.processed');
    else if(status === 'in_delivery') return trans('message.in_delivery');
    else if(status === 'ready_for_delivery') return trans('message.ready_for_delivery');
    else if(status === 'rejected_by_provider') return trans('message.ready_for_delivery');
    else if(status === 'ready_for_pick_up') return trans('message.ready_for_pick_up');
    else if(status === 'received') return trans('message.received');
    else if(status === 'not_received') return trans('message.notReceived');
    else if(status === 'delivered') return trans('message.delivered');
    else if(status === 'retrieving') return trans('message.retrieving');
}

export function getCurrentStatusClass(status) {
    if (status === 'pending') return 'custom-gray-color';
    else if (status === 'rejected') return 'custom-red-color';
    else if (status === 'accepted' || status === 'in_delivery') return 'custom-success-color';
    else if (status === 'ready_for_pick_up' || status === 'received' || status === 'delivered') return 'custom-success-color';
    else if (status === 'returns') return 'custom-gold-color';
    else if (status === 'ready_for_delivery') return 'custom-success-color';
    else if (status === 'rejected_by_provider') return 'custom-success-color';
    else if (status === 'retrieving') return 'custom-purple-color';
    else if (status === 'processing') return 'custom-purple-color';
    else if (status === 'not_received') return 'custom-gold-color';
}

export function getPaymentStatus(status) {
    if(status === 'delayed') return trans('message.delayed');
    else if(status === 'not_paid') return trans('message.not_paid');
    else if(status === 'wait_to_pay') return trans('message.wait_to_pay');
    else if(status === 'owes_a_delay') return trans('message.owes_a_delay');
    else if(status === 'paid') return trans('message.paid');
}
