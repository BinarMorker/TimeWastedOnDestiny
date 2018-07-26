/*eslint no-unused-vars: ["error", { "varsIgnorePattern": "app" }]*/

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import App from './App.vue'

Vue.use(BootstrapVue)

const app = new Vue({
  el: '#app',
  render: h => h(App)
})

setTimeout(() => {
  document.querySelectorAll('img.svg').forEach(img => {
    const imgID = img.id
    const imgClass = img.className
    const imgURL = img.src

    fetch(imgURL).then(response => {
      return response.text()
    }).then(text => {
      const parser = new DOMParser()
      const xmlDoc = parser.parseFromString(text, "text/xml")

      // Get the SVG tag, ignore the rest
      const svg = xmlDoc.getElementsByTagName('svg')[0]

      // Add replaced image's ID to the new SVG
      if (typeof imgID !== 'undefined') {
        svg.setAttribute('id', imgID)
      }
      // Add replaced image's classes to the new SVG
      if (typeof imgClass !== 'undefined') {
        svg.setAttribute('class', imgClass+' replaced-svg')
      }

      // Remove any invalid XML tags as per http://validator.w3.org
      svg.removeAttribute('xmlns:a')

      // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
      if (!svg.getAttribute('viewBox') && svg.getAttribute('height') && svg.getAttribute('width')) {
        svg.setAttribute('viewBox', '0 0 ' + svg.getAttribute('height') + ' ' + svg.getAttribute('width'))
      }

      // Replace image with new SVG
      img.parentNode.replaceChild(svg, img)
    })
  })
}, 100)
