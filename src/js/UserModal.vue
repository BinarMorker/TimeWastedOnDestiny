<template>
  <b-modal class="user-modal" :class="user.platform" :id="user.membershipId" :ref="user.membershipId" hide-header hide-footer centered>
    <b-button-close @click="hideModal"></b-button-close>
    <div class="badges">
      <img class="version svg" :src="gameImg">
      <img class="platform svg" :src="platformImg">
      <span class="rank">Top {{ user.rank }}%</span>
    </div>
    <h3>{{ user.username }}</h3>
    <labeled-data label="Time played" :data="timePlayed"></labeled-data>
  </b-modal>
</template>

<script>
  import path from 'path'
  import LabeledData from './LabeledData'
  import xbImg from '../assets/xb.svg'
  import pcImg from '../assets/pc.svg'
  import psImg from '../assets/ps.svg'
  import d1Img from '../assets/one.svg'
  import d2Img from '../assets/two.svg'

  const ASSET_PATH = process.env.NODE_ENV === 'production' ? '/dist' : ''

  export default {
    name: 'user-modal',
    components: {
      LabeledData
    },
    props: [ 'user' ],
    computed: {
      timePlayed() {
        return this.user.time
      },
      platformImg() {
        let platformImg = ''

        switch (this.user.platform) {
          case 'blizzard':
            platformImg = pcImg
            break
          case 'playstation':
            platformImg = psImg
            break
          case 'xbox':
            platformImg = xbImg
            break
        }

        return path.join(ASSET_PATH, platformImg)
      },
      gameImg() {
        let gameVersionImg = ''

        switch (+this.user.game) {
          case 1:
            gameVersionImg = d1Img
            break
          case 2:
            gameVersionImg = d2Img
            break
        }

        return path.join(ASSET_PATH, gameVersionImg)
      }
    },
    methods: {
      hideModal() {
        this.$refs[this.user.membershipId].hide()
      }
    }
  }
</script>

<style>
  .user-modal .modal-content {
    position: relative !important;
    margin-bottom: 20px;
    border: 0;
    border-radius: 5px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
  }

  .user-modal.playstation .modal-content {
    border-top: 10px solid #1525dc;
  }

  .user-modal.blizzard .modal-content {
    border-top: 10px solid #2e2c2f;
  }

  .user-modal.xbox .modal-content {
    border-top: 10px solid #107c10;
  }

  .user-modal .version {
    display: inline-block;
    height: 40px;
    padding: 3px;
    width: auto;
    fill: #000000;
  }

  .user-modal .platform {
    display: inline-block;
    height: 40px;
    padding: 3px;
    width: auto;
    fill: #000000;
  }

  .user-modal .rank {
    padding: 3px;
  }
</style>