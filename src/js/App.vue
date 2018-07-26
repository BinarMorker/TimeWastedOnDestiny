<template>
  <b-container>
    <b-jumbotron class="jumbotron container">
      <b-row>
        <user-card :key="user.membershipId" v-for="user of accounts[0].response.destinyAccounts" :user="user"></user-card>
      </b-row>
    </b-jumbotron>
  </b-container>
</template>

<script>
  import UserCard from './UserCard'

  export default {
    name: 'App',
    components: {
      UserCard
    },
    data: () => {
      return {
        accounts: [
          {"version":"1.5","code":1,"response":{"bungieNetUser":{"membershipId":664856,"displayName":"BinarMorker"},"destinyAccounts":[{"membershipType":2,"membershipId":"4611686018434621158","gameVersion":1,"displayName":"BinarMorker","dateLastPlayed":{"date":"2018-07-24 21:56:50.000000","timezone_type":2,"timezone":"Z"}},{"membershipType":2,"membershipId":"4611686018434621158","gameVersion":2,"displayName":"BinarMorker","dateLastPlayed":{"date":"2018-07-24 21:35:45.000000","timezone_type":2,"timezone":"Z"}},{"membershipType":4,"membershipId":"4611686018467210709","gameVersion":2,"displayName":"BinarMorker","dateLastPlayed":{"date":"2018-07-24 04:47:44.000000","timezone_type":2,"timezone":"Z"}}]},"message":"Ok","queryTime":{"date":"2018-07-25 23:21:20.000000","timezone_type":3,"timezone":"America/Montreal"},"executionMilliseconds":3407.6058864594}
        ],
        users: [
          { membershipId: '1', username: 'binarmorker#1157', platform: 'blizzard', game: '2', time: '25h 12m 45s', rank: 5 },
          { membershipId: '2', username: 'BinarMorker', platform: 'playstation', game: '2', time: '64h 16m 14s', rank: 12 },
          { membershipId: '3', username: 'BinarMorker', platform: 'playstation', game: '1', time: '425h 34m 29s', rank: 1 }
        ]
      }
    }
  }
</script>

<style scoped>

</style>