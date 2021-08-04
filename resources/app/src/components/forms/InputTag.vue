<style lang="postcss" scoped>
    .tag-container {
        @apply border leading-6 px-2 flex flex-wrap py-1;
    }
    
    .tag-container > .tag {
        @apply bg-gray-500 text-white flex mr-1 mb-1 rounded-sm;
    }

    .tag-container > .tag > * {
        @apply px-2 leading-6;
    }

    .tag-container > .tag > button {
        @apply border-l border-gray-400;
    }
    
    .tag-container .input {
        @apply border-none block outline-none focus:outline-none p-0 flex-1;
    }
</style>

<template>
    <div>
        <div class="tag-container">
            <div class="tag" v-for="tag in tags" :key="tag">
                <label>{{tag}}</label>  
                <button @click="removeTag(tag)">x</button>
            </div>
            <input type="text" v-model="searchText" ref="input" class="input">
        </div>
        <ul>
            <li v-for="(opt, idx) in filteredOptions" :key="idx" class="hover:bg-blue-200 cursor-pointer" @click="addTag(opt)">{{opt}}</li>
        </ul>
    </div>
</template>
<script>
import {ref} from 'vue'
import {debounce} from 'lodash'

const debouncer = {
    searchText: '',
    filteredOptions: [],
    search: debounce(function (searchText, options) {
        if (searchText === '') {
           return [];
        }
        this.filteredOptions = options.filter(o => {
                const match = o.match(new RegExp(searchText, 'gi'));
                return match !== null
            })

    }, 100)
}

export default {
    name: 'ComponentName',
    props: {
        
    },
    setup() {
        let searchText = ref(debouncer.searchText);
        let copiedText = ref(debouncer.copiedtext);
        let filteredOptions = ref(debouncer.filteredOptions);
        const search = debouncer.search;

        return {searchText, copiedText, search, filteredOptions};
    },
    data() {
        return {
            // searchText: '',
            copied: '',
            tags: ['test', 'beans', 'monkeys'],
            options: [
                'monkeys',
                'beans',
                'early dogs',
                'bird cats',
                'nini pants',
                'painted plastic pumpkins',
                'fake plastic watering cans'
            ],
        }
    },
    watch: {
        searchText (to) {
            this.search(to, this.options);
        }
    },
    methods: {
        removeTag(tag){
            const idx = this.tags.findIndex(t => t == tag);
            if (idx > -1) {
                this.tags.splice(idx, 1);
            }
        },
        addTag(tag) {
            this.tags.push(tag);
            this.searchText = '';
            this.filteredOptions = [];
            this.$refs.input.focus();
        }
    }
}
</script>