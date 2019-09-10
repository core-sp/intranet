<template>
    <div class="refresh">
        <button @click="spinButton(); reloadPage();" class="refresh-button"><i class="fas fa-redo" :class="(spin === true) ? 'spin' : ''"></i></button>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                spin: false
            };
        },

        methods: {
            reloadPage() {
                window.location.reload();
            },
            
            spinButton() {
                this.spin = true;
            }
        }
    }
</script>

<style>
    .refresh {
        align-self: center;
        margin-left: 7.5px;
    }

    .refresh-button {
        padding: 12px 12px 7px 12px;
        border-radius: 5px;
    }

    .refresh-button i {
        color: #000000;
        font-size: 20px;
        line-height: 1;
        margin-bottom: 0px;
    }

    .spin {
        -webkit-animation-name: spin;
        -webkit-animation-duration: 500ms;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: linear;
        -moz-animation-name: spin;
        -moz-animation-duration: 500ms;
        -moz-animation-iteration-count: infinite;
        -moz-animation-timing-function: linear;
        -ms-animation-name: spin;
        -ms-animation-duration: 500ms;
        -ms-animation-iteration-count: infinite;
        -ms-animation-timing-function: linear;
        
        animation-name: spin;
        animation-duration: 500ms;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }

    @-moz-keyframes spin {
        from { -moz-transform: rotate(0deg); }
        to { -moz-transform: rotate(360deg); }
    }
    @-webkit-keyframes spin {
        from { -webkit-transform: rotate(0deg); }
        to { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }
</style>