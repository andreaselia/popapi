
require('./bootstrap');

var vueApiInput = new Vue({
    el: '#vueApiInput',
    data: {
        userInput: 'marvel/5920',
        failInput: false
    },
    mounted: function () {
        this.$nextTick(function () {
            this.getAPI()
        })
    },
    methods: {
        checkFail: function () {
            this.failInput = false
        },

        getAPI: function() {
            this.$http.get('http://dev.popapi.co/api/'+((this.userInput == '') ? 'marvel/5920' : this.userInput)+'?format=json').then(function (response) {
                vueApiOutput.apiResponse = JSON.stringify(response, undefined, 2)
            });

        }
    }
});

var vueApiOutput = new Vue({
    el: '#vueApiOutput',
    data: {
        apiResponse: ''
    }
});
