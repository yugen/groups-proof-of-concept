<style lang="postcss" scoped>
    .search-select-container {
        @apply border leading-6 px-2 flex flex-wrap py-1;
    }
    
    .search-select-container > .selection {
        @apply bg-gray-500 text-white flex mr-1 mb-1 rounded-sm;
    }

    .search-select-container > .selection > * {
        @apply px-2 leading-6;
    }

    .search-select-container > .selection > button {
        @apply border-l border-gray-400;
    }
    
    .search-select-container .input {
        @apply border-none block outline-none focus:outline-none p-0 flex-1;
    }

    .filtered-option {
        @apply hover:bg-blue-200 cursor-pointer focus:bg-blue-200;
    }
    .filtered-option.highlighted {
        @apply bg-blue-300;
    }
</style>

<template>
    <div>
        <div class="search-select-container">
            <div class="selection" v-if="hasSelection">
                <label>
                    <slot name="selection-label" :selection="selection">
                        {{selection}}
                    </slot>
                </label>  
                <button @click="removeSelection()">x</button>
            </div>
            <input 
                type="text" 
                v-model="searchText" 
                ref="input" 
                class="input" 
                v-show="showInput" 
                @keyup="handleKeyEvent"
                @blur="clearInput"
            >
        </div>
        <ul>
            <li v-for="(opt, idx) in filteredOptions" 
                :key="idx" 
                class="filtered-option"
                :class="{highlighted: (idx === cursorPosition)}" 
                @click="setSelection(opt)"
            >
                <slot :option="opt" :index="idx" name="option">{{opt}}</slot>
            </li>
        </ul>
    </div>
</template>
<script>
import {ref, reactive, computed} from 'vue'
import {throttle} from 'lodash'

const isAbsent = Symbol();

const debouncer = {
    prepareSearchFunction: function(searchFunction) {
        return throttle(searchFunction, 100, {'tail': true});
    }
}

export default {
    name: 'ComponentName',
    props: {
        searchFunction: {
            required: false,
            type: Function
        },
        modelValue: {
            required: true
        },
        options: {
            required: false,
            default: []
        },
    },
    emits: [
        'update:modelValue',
    ],
    setup(props) {
        let searchText = ref('');
        let cursorPosition = ref(0);
        let filteredOptions = reactive([]);

        let search = debouncer.prepareSearchFunction(props.searchFunction);
        if (props.searchFunction === isAbsent)  {
            let search = debouncer.prepareSearchFunction(function (searchText, options) {
                if (searchText === '') {
                return [];
                }
                return options.filter(o => {
                        const match = o.name.match(new RegExp(searchText, 'gi'));
                        return match !== null
                    })

            });
        }

        return {searchText, search, filteredOptions, cursorPosition};
    },
    data() {
        return {
            
        }
    },
    computed: {
        selection() {
            return this.modelValue;
        },
        showInput() {
            return !this.hasSelection;
        },
        showingOptions() {
            return this.filteredOptions.length > 0;
        },
        highlightedOption() {
            if (this.showingOptions) {
                return null;
            }
            return this.filteredOptions[this.cursorPosition];
        },
        hasSelection() {
            return Boolean(this.selection)
        },
    },
    watch: {
        searchText (to) {
            this.search(to, this.options);
            this.filteredOptions = this.search(this.searchText, this.options);
        }
    },
    methods: {
        removeSelection(    ){
            this.$emit('update:modelValue', null);
            this.$refs.input.focus();
        },
        setSelection(selection) {
            this.$emit('update:modelValue', selection);
            // this.selection = selection;
            console.log(this.selection);
            this.clearInput();
            this.resetCursor();
        },
        clearInput() {
            this.filteredOptions = [];
            this.searchText = '';
        },
        resetCursor() {
            this.cursorPosition = 0;
        },
        handleKeyEvent(evt) {
            if (this.showingOptions) {
                if (evt.key == 'ArrowDown') {
                    if (this.cursorPosition+1 >= this.filteredOptions.length) {
                        return;
                    }
                    this.cursorPosition++;
                    return;
                }
                if (evt.key == 'ArrowUp') {
                    if (this.cursorPosition-1 < 0) {
                        return;
                    }
                    this.cursorPosition--;
                    return;
                }
                if (['Tab', 'Enter'].indexOf(evt.key) > -1) {
                    evt.preventDefault();
                    console.info('enter', this.cursorPosition)
                    console.info('this.filteredOptions[this.cursorPosition]', this.filteredOptions[this.cursorPosition])
                    this.setSelection(this.filteredOptions[this.cursorPosition])
                }
            }
        }
    }
}
</script>