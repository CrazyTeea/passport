export const mainMixin = {
    methods: {
        toNum: num => typeof num === 'string' ? num.toNumber() : (num || 0),
        goTo(url) {
            window.location.href = url;
        },
        showModal() {
            this.$refs['error-modal'].show();
        },
        hideModal() {
            this.$refs['error-modal'].hide();
        },
        goToStep(step, back, to) {
            switch (step) {
                case 0:
                    this.goTo(back);
                    break;
                case 1:
                    this.goTo(to);
                    break;
            }
        },
        isEmpty(item) {
            return item === null || item === undefined || item === '' || item === 'null';
        },
    },
    filters: {
        toFixed(val) {
            return typeof val === 'number' ? val.toFixed(2) : val
        }
    }
};