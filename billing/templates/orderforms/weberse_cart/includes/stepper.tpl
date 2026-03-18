{* Weberse Cart - SaaS-style checkout stepper *}
{assign var=_step value=$step|default:'products'}

<div class="weberse-stepper" aria-label="Checkout progress">
    <div class="weberse-step {if $_step == 'products'}is-active{elseif in_array($_step, ['configure','review','checkout','complete'])}is-done{/if}">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Choose</div>
            <div class="weberse-step-sub">Plan</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step {if $_step == 'configure'}is-active{elseif in_array($_step, ['review','checkout','complete'])}is-done{/if}">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Configure</div>
            <div class="weberse-step-sub">Options</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step {if $_step == 'review'}is-active{elseif in_array($_step, ['checkout','complete'])}is-done{/if}">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Review</div>
            <div class="weberse-step-sub">Cart</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step {if $_step == 'checkout'}is-active{elseif in_array($_step, ['complete'])}is-done{/if}">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Checkout</div>
            <div class="weberse-step-sub">Details</div>
        </div>
    </div>
    <div class="weberse-step-line"></div>

    <div class="weberse-step {if $_step == 'complete'}is-active{/if}">
        <div class="weberse-step-dot"><i class="fas fa-check"></i></div>
        <div class="weberse-step-meta">
            <div class="weberse-step-title">Done</div>
            <div class="weberse-step-sub">Finish</div>
        </div>
    </div>
</div>

