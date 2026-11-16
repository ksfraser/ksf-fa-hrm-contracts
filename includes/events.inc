<?php
declare(strict_types=1);

if (!function_exists('hook_invoke_all')) {
    return;
}

function contract_state_changed($contractId, $fromState, $toState, $meta = array()) {
    hook_invoke_all('CONTRACT_STATE_CHANGED', array(
        'contract_id' => $contractId,
        'from_state' => $fromState,
        'to_state' => $toState,
        'meta' => $meta,
    ));
}
