<template>
  <div class="col-xl-4 col-md-6">
    <b-card class="user-card" :title="user.displayName" :class="platformName">
      <labeled-data label="Time played" :data="timePlayed"></labeled-data>
      <b-button class="btn-more" v-b-modal="user.membershipId">VIEW MORE</b-button>
      <img class="version svg" :src="gameImg">
      <img class="platform svg" :src="platformImg">
      <div class="rank">Top {{ user.rank }}%</div>
      <div class="d-lg">
        AAAAAAAAAAAAAAAA<br/>AAAAAAAAAAAAAAAAAAAA<br/>AAAAAAAAAAAAAAAAA
      </div>
    </b-card>
    <user-modal :user="user"></user-modal>
  </div>
</template>

<script>
  import path from 'path'
  import LabeledData from './LabeledData'
  import UserModal from './UserModal'
  import xbImg from '../assets/xb.svg'
  import pcImg from '../assets/pc.svg'
  import psImg from '../assets/ps.svg'
  import d1Img from '../assets/one.svg'
  import d2Img from '../assets/two.svg'

  const ASSET_PATH = process.env.NODE_ENV === 'production' ? '/dist' : ''

  export default {
    name: 'user-card',
    props: [ 'user' ],
    components: {
      LabeledData,
      UserModal
    },
    computed: {
      timePlayed() {
        return this.user.time
      },
      platformName() {
        let platformName = ''

        switch (this.user.membershipType) {
          case 4:
            platformName = 'blizzard'
            break
          case 2:
            platformName = 'playstation'
            break
          case 1:
            platformName = 'xbox'
            break
        }

        return platformName
      },
      platformImg() {
        let platformImg = ''

        switch (this.user.membershipType) {
          case 4:
            platformImg = pcImg
            break
          case 2:
            platformImg = psImg
            break
          case 1:
            platformImg = xbImg
            break
        }

        return path.join(ASSET_PATH, platformImg)
      },
      gameImg() {
        let gameVersionImg = ''

        switch (+this.user.gameVersion) {
          case 1:
            gameVersionImg = d1Img
            break
          case 2:
            gameVersionImg = d2Img
            break
        }

        return path.join(ASSET_PATH, gameVersionImg)
      }
    }
  }
</script>

<style>
  .user-card .version {
    position: absolute;
    top: 0;
    left: -20px;
    width: 20px;
    padding: 3px;
    height: auto;
    fill: #ffffff;
  }

  .user-card .platform {
    position: absolute;
    bottom: 0;
    left: -20px;
    width: 20px;
    padding: 3px;
    height: auto;
    fill: #ffffff;
  }
</style>

<style scoped>
  .card {
    position: relative;
    margin-bottom: 20px;
    border: 0;
    border-radius: 5px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
  }

  .card-body {
    padding: 10px;
  }

  .card.playstation {
    border-left: 20px solid #1525dc;
  }

  .card.blizzard {
    border-left: 20px solid #2e2c2f;
  }

  .card.xbox {
    border-left: 20px solid #107c10;
  }

  .rank {
    position: absolute;
    top: 0;
    right: 0;
    padding: 5px;
    font-size: 10px;
  }

  .btn-more {
    width: 70px;
    line-height: 10px;
    font-size: 10px;
    text-align: right;
    white-space: normal;
    padding-right: 30px;
    padding-left: 5px;
    position: absolute;
    bottom: 10px;
    right: 10px;
    border-radius: 100px;
  }

  .btn-more::after {
    content: '+';
    font-size: 30px;
    position: absolute;
    top: 8px;
    right: 5px;
  }
</style>