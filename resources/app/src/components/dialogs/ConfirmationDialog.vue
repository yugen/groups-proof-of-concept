
<template>
    <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center content-center z-50" 
        @keyup.esc="close"
        v-show="modelValue"
    >
        <div 
            id="modal-backdrop" 
            class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50" 
            @click="close"
        ></div>

        <div class="bg-white p-4 border border-gray-500 opacity-100 relative mt-24 mb-auto rounded-lg shadow-md" :class="width">
            <button 
                @click="close" class="btn btn-xs gray float-right"
                v-if="!hideClose"
            >X</button>
            <header>
                <slot name="header">
                    <h2 class="pb-2 border-b mb-2" v-if="title">{{title}}</h2>
                </slot>
            </header>
            <slot name="default" />
            <ButtonRow
                :submit-text="yesLabel"
                :cancel-text="noLabel"
                @canceled="$emit('canceled')" 
                @submitted="$emit('confirmed')"
            >
        </div>
    </div>
</template>
<script>
import ButtonRow from '@/components/forms/RowButton.vue';

export default {
    name: 'ConfirmationDialog',
    components: {
        ButtonRow
    },
    props: {
        yesLabel: {
            type: String,
            required: false,
            default: 'Continue'
        },
        noLabel: {
            type: String,
            required: false,
            default: 'Cancel'
        },
    },
    emits: [
        'canceled',
        'confirmed'
    ]
}
</script>