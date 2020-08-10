<template>
    <button @click="toggleSubscription" class="btn btn-danger">
        {{ owner ? '' : subscribed ? 'Unsubscribe' : 'Subscribe' }} {{ count }} {{ owner ? 'Subscribers' : '' }}
    </button>
</template>

<script>
import numeral from "numeral";

export default {
    props: {
        initialSubscriptions: {
            type: Array,
            required: true,
            default: () => []
        },

        channel: {
            type: Object,
            required: true,
            default: () => {}
        }
    },

    data: function () {
        return {
            subscriptions: this.initialSubscriptions
        }
    },

    computed: {
        subscribed() {
            if(! __auth() || this.channel.user_id === __auth().id) {
                return false;
            }

            return !!this.subscription;
        },

        owner() {
            return (__auth() && this.channel.user_id === __auth().id);
        },

        count() {
            return numeral(this.subscriptions.length).format('0a');
        },

        subscription() {
            if(! __auth()) {
                return null;
            }

            return this.subscriptions.find(subscription => subscription.user_id == __auth().id);
        }
    },

    methods: {
        toggleSubscription() {
            if(! __auth()) {
                alert("Please login to subscribe.");
            }

            if(this.owner) {
                return alert('You cannot subscribe to your channel.');
            }

            if(this.subscribed) {
                axios.delete(`${appUrl}/channels/${this.channel.id}/subscriptions/${this.subscription.id}`)
                    .then(() => {
                        this.subscriptions = this.subscriptions.filter(s => s.id !== this.subscription.id);
                    });
            } else {
                axios.post(`${appUrl}/channels/${this.channel.id}/subscriptions`)
                    .then((response) => {
                        this.subscriptions = [...this.subscriptions, response.data ];
                    });
            }
        }
    }
}
</script>

<style scoped>

</style>
