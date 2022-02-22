import Component from '@okiba/component'
import { qs, on, off } from '@okiba/dom'
import { debounce } from '@okiba/functions'

import gsap from 'gsap'

const ui = {
    items: {
        selector: '.lb-accordion__item',
        asArray: true
    }
}

const defaultOptions = { keepOpened: true, duration: 0.4 }

class Accordion extends Component {

    constructor({ el, options }) {
        super({ el, ui })

        this.options = {
            ...defaultOptions,
            ...options
        }

        this.screenWidth = window.innerWidth

        this.items = this.ui.items.reduce((acc, item) => {
            const header = qs('.lb-accordion__header', item)

            on(header, 'click', this.handleToggle)

            acc.set(header, {
                header,
                content: qs('.lb-accordion__content', item),
                wrapper: item
            })

            return acc
        }, new Map())

        on(window, 'resize', this.handleResize)
    }

    handleResize = debounce(() => {
        if (this.screenWidth !== window.innerWidth) {
            this.close(false)
        }
        this.screenWidth = window.innerWidth
    }, 300)

    handleToggle = (e) => {
        if (e.target.classList.contains('button') ||
            e.target.classList.contains('button__label') ||
            e.target.matches('input') ||
            e.target.matches('svg[aria-label="check"]')) return
            
        const target = e.target.closest('.lb-accordion__header')
        const item = this.items.get(target)

        if (item.wrapper.classList.contains('is-open')) {
            this.close(item)
        } else {
            if (!this.options.keepOpened) this.close()
            this.open(item)
        }
    }

    open(target) {
        if (!target) return

        const height = target.header.offsetHeight + target.content.offsetHeight

        target.wrapper.classList.add('is-opening')

        gsap.to(target.wrapper, {
            height: `${height}px`,
            duration: this.options.duration,
            onComplete: () => {
                target.wrapper.classList.remove('is-opening')
                target.wrapper.classList.add('is-open')
            }
        })
    }

    close(target) {
        if (target) {
            if (target.wrapper.classList.contains('default-open')) return
            const height = target.header.offsetHeight

            gsap.to(target.wrapper, {
                height: `${height}px`,
                duration: this.options.duration,
                onComplete: () => target.wrapper.classList.remove('is-open')
            })
        } else {
            this.items.forEach((el) => this.close(el))
        }
    }

    onDestroy() {
        this.items.forEach(({ header }) => off(header, 'click', this.handleToggle))
        off(window, 'resize', this.handleResize)
    }
}

export default Accordion