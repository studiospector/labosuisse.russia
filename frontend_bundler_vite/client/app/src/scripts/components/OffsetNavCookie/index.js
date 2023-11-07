import Component from '@okiba/component'
import { qs, qsa, on, off } from '@okiba/dom'

import { setCookie, getCookie } from "../../utils/cookie";

const ui = {
    textWrapper: {
        selector: '.lb-offset-nav__content__item--image-text__text-wrapper'
    }
}

class OffsetNavCookieManagement extends Component {

    constructor({ options, ...props }) {
        super({ ...props, ui })

        this.delay = Number(this.el.dataset?.delay)
        this.cookieExpire = Number(this.el.dataset?.cookieExpire)

        this.cookie = getCookie(`${this.el.id}-closed`)

        if (!Boolean(this.cookie)) {
            setTimeout(() => window.openOffsetNav(this.el.id), this.delay);
        }

        on(this.el, 'closeOffsetNav', () => {
            setCookie(`${this.el.id}-closed`, true, this.cookieExpire)
        })

        mc4wp.forms.on('submitted', (form) => {
            if (this.ui.textWrapper) {
                this.ui.textWrapper.classList.add('lb-offset-nav__content__item--image-text__text-wrapper--hide')
            }
        })
    }
}

export default OffsetNavCookieManagement
