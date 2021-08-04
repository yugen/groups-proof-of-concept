<template>
    <div class="container text-left">
        <p>HOMIES!!</p>
        <button @click="getTestData">Get Test Data</button>
        <div class="border p-3 ml-4 mt-2 " v-show="testData">
            <pre>{{testData}}</pre>
            <button @click="testData = null">Clear</button>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Example Home Component',
    props: {
        
    },
    data() {
        return {
            testData: null
        }
    },
    computed: {

    },
    methods: {
        getTestData () {
            console.log('getTestData');
            fetch('/api/test')
                .then(response => response.json())
                .then(data => {
                    this.testData = data
                })
                .catch(error => console.error(error));
        }
    }
}
</script>