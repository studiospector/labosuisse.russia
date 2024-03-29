import { document } from 'global'
import { storiesOf } from '@storybook/html'
import { appendChildren } from '../utils'

storiesOf('UIKit|Typography', module)
    .add('Titles', () => {
        const div = document.createElement('div')
        appendChildren('<h1>Lorem Ipsum Dolor Sit Amet</h1>', div)
        appendChildren('<h2>Lorem Ipsum Dolor Sit Amet</h2>', div)
        appendChildren('<h3>Lorem Ipsum Dolor Sit Amet</h3>', div)
        appendChildren('<h4>Lorem Ipsum Dolor Sit Amet</h4>', div)
        appendChildren('<h5>Lorem Ipsum Dolor Sit Amet</h5>', div)
        appendChildren('<h6>Lorem Ipsum Dolor Sit Amet</h6>', div)
        appendChildren('<p class="p-small">Lorem Ipsum Dolor Sit Amet</p>', div)
        appendChildren('<p>Lorem Ipsum Dolor Sit Amet</p>', div)
        appendChildren('<p class="p-big">Lorem Ipsum Dolor Sit Amet</p>', div)
        return div.innerHTML
    })
