import Component from '@okiba/component'
import CarouselHero from './CarouselHero'
import CarouselPosts from './CarouselPosts'
import Hero from './Hero'

const components = {
  carouselHero: {
    selector: '.js-carousel-hero',
    type: CarouselHero,
    optional: true
  },
  carouselPosts: {
    selector: '.js-carousel-posts',
    type: CarouselPosts,
    optional: true
  },
  hero: {
    selector: '.js-hero',
    type: Hero,
    optional: true
  },
}

export default class Application extends Component {
  constructor() {
    super({ el: document.body, components })

    this.el.classList.add('ready')
  }
}
