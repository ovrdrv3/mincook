<template>
    <div class="mb-3 image-container">
        <!-- If there is more than one image -->
        <!-- Upon hover, show fancy arrows to navigate through photos -->
        <font-awesome-icon class="image-nav dark-purple" style="left:15px;" icon="arrow-left" size="lg" @click="prev"></font-awesome-icon>
        <font-awesome-icon class="image-nav dark-purple" style="left:100px;" icon="arrow-right" size="lg" @click="next"></font-awesome-icon>
        <!-- TODO: get this transition smooth. -->
        <img style="max-height: 800px;" :src="currentImage"/>


</div>
</template>
<style>

    .image-container{
        position: relative;
    }

    /* Navbar links */
    .image-nav {
      position:absolute;
      top: 15px;

    }
</style>
<script>
export default {
    props: {
      images: {
        type: Array
      }
    },
    data() {
        return {
            currentNumber: 0,
            timer: null
        }
    },

    mounted: function () {
        this.startRotation();
    },

    methods: {
        startRotation: function() {
            // this.timer = setInterval(this.next, 3000);
        },

        stopRotation: function() {
            clearTimeout(this.timer);
            this.timer = null;
        },

        next: function() {
            this.currentNumber += 1
        },
        prev: function() {
            this.currentNumber -= 1
        }
    },

    computed: {
        currentImage: function() {
        return this.images[Math.abs(this.currentNumber) % this.images.length];
      }
    }
}

</script>
