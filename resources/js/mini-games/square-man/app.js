import Alpine from 'alpinejs'

window.Alpine = Alpine;

window.NumberHelpers = {
    formatTimer: (totalSeg) => {
        totalSeg = parseInt(totalSeg);
        totalSeg = !isNaN(totalSeg) && totalSeg > 0 ? totalSeg : 0;

        let min = parseInt(totalSeg / 60);
        let seg = totalSeg % 60;
        let formated = [min, seg].map(item => item.toString().padStart(2, 0)).join(':');

        return {
            min,
            seg,
            totalSeg,
            totalLeft: totalSeg,
            formated,
        };
    },
};

document.addEventListener('alpine:init', () => {
    Alpine.data('gameData', () => ({
        score: 0,
        giftOn: 0,
        position: 0,
        topMessage: '',
        timerConfig: {
            minutes: 0,
            seconds: 5,
        },
        currentTimeLeft: {
            formatTimer: null,
            intervalID: null,
        },
        init() {
            console.log('init', this.$refs?.gameControl);
            this.startNewGame();
        },

        get width() {
            return 8;
        },

        get height() {
            return 8;
        },

        get fieldSize() {
            return (this.width * this.height);
        },

        get giftContent() {
            return `🎁`;
        },

        get timeLeft() {
            if (!this.currentTimeLeft || !this.currentTimeLeft?.formatTimer) {
                return '';
            }

            return this.currentTimeLeft?.formatTimer?.formated || '::'
        },

        get canPlay() {
            if (!this.currentTimeLeft || !this.currentTimeLeft?.formatTimer) {
                return false;
            }

            let totalLeft = this.currentTimeLeft?.formatTimer?.totalSeg ||
                this.currentTimeLeft?.formatTimer?.totalLeft;

            totalLeft = parseInt(totalLeft);

            return !isNaN(totalLeft) && totalLeft > 0 ? true : false;
        },

        countdownTimer(minutes = 0, seconds = 0, whenFinish = null) {
            whenFinish = typeof whenFinish === 'function' ? whenFinish : (fmt) => {
                console.log('Finished!', fmt);
            };

            minutes = parseInt(minutes);
            minutes = !isNaN(minutes) && minutes > 0 ? minutes : 0;

            seconds = parseInt(seconds);
            seconds = !isNaN(seconds) && seconds > 0 ? seconds : 0;

            let totalSeg = (minutes * 60) + seconds;
            let value = totalSeg;

            if (this.currentTimeLeft.intervalID && !isNaN(parseInt(this.currentTimeLeft.intervalID))) {
                clearInterval(this.currentTimeLeft.intervalID);
            }

            this.currentTimeLeft.intervalID = setInterval(() => {
                let formatedValue = globalThis?.NumberHelpers?.formatTimer(value);
                this.currentTimeLeft.formatTimer = formatedValue;

                if (--value < 0) {
                    clearInterval(this.currentTimeLeft.intervalID);
                    whenFinish(formatedValue);
                }

                console.log('ping', this.currentTimeLeft.intervalID, value, formatedValue);
            }, 1000);
        },

        startNewGame() {
            let {
                minutes,
                seconds,
            } = this.timerConfig;

            this.countdownTimer(minutes, seconds, (fmt) => {
                this.topMessage = 'Finalizado!';
                console.log('Finalizado!', fmt);
            });

            // this.timeLeft = '02:00';
            // NumberHelpers.countdownTimer(0, 2);
            this.score = 0;
            this.topMessage = '';
            this.newRandomPosition();
            this.newGiftPosition();
            this.focusOnGameControl();
        },

        giftContentFor(value) {
            return value === this.giftOn ? this.giftContent : '';
        },

        focusOnGameControl() {
            if (!this.$refs?.gameControl) {
                return;
            }

            this.$refs?.gameControl?.focus();
        },

        whenClickOnGameFild(event) {
            console.log('whenClickOnGameFild', event);
            this.focusOnGameControl();
        },

        setPosition(newPosition) {
            newPosition = parseInt(newPosition);

            if (isNaN(newPosition)) {
                return;
            }

            if (newPosition > this.fieldSize) {
                return;
            }

            if (newPosition < 1) {
                return;
            }

            if (this.position === newPosition) {
                return;
            }

            this.position = newPosition;

            if (newPosition === this.giftOn) {
                this.catchGift();
            }
        },

        catchGift() {
            this.incrementScore();
            this.newGiftPosition();
        },

        randomNumber(min = 1, max = 1000, except = [], maxRetry = 300) {
            const generateValue = () => Math.floor(Math.random() * (max - min)) + 1;

            let newValue = generateValue();

            if (!except.includes(newValue)) {
                return newValue;
            }

            for (let i = 0; i <= maxRetry; i++) {
                newValue = generateValue();

                if (!except.includes(newValue)) {
                    return newValue;
                }
            }

            return null;
        },

        randomPosition(except = []) {
            return this.randomNumber(1, this.fieldSize, except);
        },

        newGiftPosition() {
            let newGiftPosition = this.randomPosition([
                this.giftOn,
                this.position,
            ]);

            this.giftOn = newGiftPosition;
        },

        newRandomPosition() {
            let newGiftPosition = this.randomPosition([
                this.giftOn,
                this.position,
            ]);

            this.position = newGiftPosition;
        },

        incrementScore() {
            this.score = this.score + 1;
        },

        incrementPosition() {
            this.setPosition(this.position + 1);
        },

        decrementPosition() {
            this.setPosition(this.position - 1);
        },

        onArrowUp() {
            console.log('onArrowUp');
            this.setPosition(this.position - this.width);
        },

        onArrowRight() {
            console.log('onArrowRight');

            if (this.position % this.width === 0) {
                return;
            }

            this.incrementPosition();
        },

        onArrowLeft() {
            console.log('onArrowLeft');

            if ((this.position - 1) % this.width === 0) {
                return;
            }

            this.decrementPosition();
        },

        onArrowDown() {
            console.log('onArrowDown');
            this.setPosition(this.position + this.width);
        },

        gameControlKeyUpAction(event) {
            // console.log('gameControlKeyUpAction', event);
        },

        gameControlKeyDownAction(event) {
            let { key, code, keyCode, ctrlKey, shiftKey } = event;

            if (event?.target) {
                event.target.value = '';
            }

            let lKey = [code, key].includes('KeyL') || [code, key].includes('L') || keyCode === 76;

            if (lKey && ctrlKey && shiftKey) {
                console.clear();
                return;
            }

            if (!this.canPlay) {
                console.log('this.canPlay', this.canPlay);
                return;
            }

            if (keyCode === 38 || [code, key].includes('ArrowUp')) {
                this.onArrowUp();
                return;
            }

            if (keyCode === 39 || [code, key].includes('ArrowRight')) {
                this.onArrowRight();
                return;
            }

            if (keyCode === 37 || [code, key].includes('ArrowLeft')) {
                this.onArrowLeft();
                return;
            }

            if (keyCode === 40 || [code, key].includes('ArrowDown')) {
                this.onArrowDown();
                return;
            }

            console.log('gameControlKeyDownAction', event);
        },
    }))
});

Alpine.start();
