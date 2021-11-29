import BasicElement from './basic-element'

class CustomSelect extends BasicElement {

    /**
     * Constructor
     */
    constructor(args) {

        super(args)

        // Vars
        this.currSelectElem = null
        this.currSelectElemLength = null
        this.mainContainer = null
        this.selectLabel = null
        this.itemSelected = null
        this.itemSelectedValue = null
        this.optionsList = null
        this.optionItem = null
        this.multiSelected = null
        this.selectVariant = null
        this.selectBtnConfirm = null

        // Init
        this.init()
    }



    /**
     * Init
     */
    init() {
        // Loop through queried <select>
        for (let i = 0; i < this.csLength; i++) {
            // Current <select>
            this.currSelectElem = this.cs[i]
            this.currSelectElemLength = this.currSelectElem.length

            // MAIN CONTAINER
            this.mainContainer = this.createDOMElement('DIV', ['custom-select'], null, null, {pos: 'beforebegin', elem: this.cs[i]})

            // VARIANT
            this.selectVariant = this.cs[i].getAttribute('data-variant')
            if (this.selectVariant) {
                this.mainContainer.classList.add(`custom-select--${this.selectVariant}`);
            }
            
            // MULTIPLE <select>
            if (this.currSelectElem.multiple) {
                this.mainContainer.classList.add('custom-select--multiple')
            }
            
            // DISABLED <select>
            if (this.currSelectElem.disabled) {
                this.mainContainer.classList.add('custom-select--disabled')
            }

            // LABEL
            const selectLabelText = this.cs[i].getAttribute('data-label')
            if (selectLabelText) {
                this.selectLabel = this.createDOMElement('DIV', ['custom-select-label'], selectLabelText, null, {pos: 'beforeend', elem: this.mainContainer})
            }

            // Move <select> into main container
            this.mainContainer.appendChild(this.cs[i])

            // For each element, create a new DIV that will act as the selected item
            this.itemSelected = this.createDOMElement('DIV', ['custom-select-container'], null, null, {pos: 'beforeend', elem: this.mainContainer})
            // When the select box is clicked, close any other select boxes, and open/close the current select box
            this.itemSelected.addEventListener('click', this.dispatchItemSelectedContainer)

            // Set selected value
            this.setSelectedValue()

            // OPTIONS LIST
            this.optionsList = this.createDOMElement('DIV', ['custom-select-items', 'custom-select-items--hide'])

            this.multiSelected = []

            // Loop through <option> of <select>
            for (let j = 1; j < this.currSelectElemLength; j++) {
                // For each <option> in the original <select> element, create a new DIV that will act as an option item
                this.optionItem = this.createDOMElement('DIV', ['custom-select-items__item'])
                this.optionItemValue = this.createDOMElement('SPAN', ['custom-select-items__item__value'], null, this.currSelectElem.options[j].innerHTML, {pos: 'afterbegin', elem: this.optionItem})
                
                // Check icon only for 'primary' variant
                if (this.selectVariant == 'primary' || this.selectVariant == 'secondary') {
                    this.createDOMElement('DIV', ['custom-select-items__item__check'], null, null, {pos: 'afterbegin', elem: this.optionItem})
                }

                // DISABLED <option>
                if (this.currSelectElem.options[j].disabled) {
                    this.optionItem.classList.add('custom-select-items__item--disabled')
                }

                // HIDDEN <option>
                if (this.currSelectElem.options[j].hidden) {
                    this.optionItem.classList.add('custom-select-items__item--hidden')
                }

                // Trigger option click
                this.optionItem.addEventListener('click', (ev) => this.dispatchSelectedOption(ev, this.multiSelected))

                // Add option item to options list
                this.optionsList.appendChild(this.optionItem)

                // if (this.selectVariant == 'primary') {
                //     this.selectButton = this.createDOMElement('DIV', ['custom-select-button'], null, null, {pos: 'afterbegin', elem: this.optionItem})
                // }
            }

            // BUTTON CONFIRM
            const selectBtnLabel = this.cs[i].getAttribute('data-btn-confirm')
            if (selectBtnLabel) {
                this.selectBtnConfirm = this.createDOMElement('BUTTON', ['custom-select-items__btn-confirm', 'button', 'button-primary'], selectBtnLabel, null, {pos: 'beforeend', elem: this.optionsList})
                this.selectBtnConfirm.addEventListener('click', this.closeCurrentSelect)
            }

            // Add option list to main container
            this.mainContainer.appendChild(this.optionsList)
        }
    }



    /**
     * When an item is clicked, update the original select box, and the selected item
     * @param {Event} ev Event emitted
     * @param {Array} multiSelected <select> selected <option> label
     */
    dispatchSelectedOption = (ev, multiSelected) => {
        let elem = ev.target.closest('.custom-select-items__item')
        let elemValue = elem.querySelector('.custom-select-items__item__value').innerText
        let select = elem.parentNode.parentNode.getElementsByTagName('select')[0]
        let selectLength = select.length
        // let selectSelected = elem.parentNode.previousSibling

        for (let i = 0; i < selectLength; i++) {
            if (select.options[i].innerHTML == elemValue) {
                // For multiple <select>
                if (select.multiple) {
                    // If is clicked an option already selected
                    if (select.options[i].selected == true) {
                        select.options[i].selected = false
                        multiSelected = multiSelected.filter(item => item != elemValue)
                        elem.classList.remove('custom-select-items__item--active')
                        this.traceClick(select)
                    // If is clicked a new option
                    } else {
                        select.options[i].selected = true
                        multiSelected.push(elemValue)
                        elem.classList.add('custom-select-items__item--active')
                        this.traceClick(select)
                    }
                    // If no option is selected, insert first option as placeholder, instead insert joined values
                    let val = null
                    if (!multiSelected.length > 0) {
                        val = select.options[0].innerText
                    } else {
                        if (this.selectVariant == 'primary') {
                            val = `${select.options[0].innerText} <strong>(${multiSelected.length})</strong>`
                        } else {
                            val = multiSelected.join(', ')
                        }
                    }
                    this.setSelectedValue(val)

                // For normal <select>
                } else {
                    select.selectedIndex = i
                    this.setSelectedValue(elemValue)
                    multiSelected[0] = elemValue
                    // Remove 'active' class from all custom options
                    let selectOptions = [...this.optionsList.children]
                    selectOptions.forEach(el => el.classList.remove('custom-select-items__item--active'))
                    // Add 'active' class to selected option 
                    elem.classList.add('custom-select-items__item--active')
                    this.traceClick(select)
                }
                this.multiSelected = multiSelected
                break;
            }
        }
        // selectSelected.click()
    }



    /**
     * When the select box is clicked, close any other select boxes, and open/close the current select box
     * @param {Event} ev Event emitted
     */
    dispatchItemSelectedContainer = (ev) => {
        ev.stopPropagation()
        this.closeAllSelect(this.itemSelected)
        this.itemSelected.nextSibling.classList.toggle('custom-select-items--hide')
        this.itemSelected.classList.toggle('custom-select-container--active')
    }



    /**
     * Set selected value
     * @param {string} value Current <option>s selected
     */
    setSelectedValue(value = null) {
        // If is first init of custom select
        if (!value) {
            this.itemSelectedValue = this.createDOMElement('SPAN', ['custom-select-value'], null, null, {pos: 'beforeend', elem: this.itemSelected})
            // Set as value the current option selected(in case of 'selected' attribute as default)
            if (this.currSelectElem.selectedIndex != -1) {
                this.itemSelectedValue.innerHTML = this.currSelectElem.options[this.currSelectElem.selectedIndex].innerHTML
            } else {
                this.itemSelectedValue.innerHTML = this.currSelectElem.options[0].innerHTML
            }
            // Add icon arrow
            this.addIconArrow()

        // If only change value of select
        } else {
            this.itemSelectedValue.innerHTML = value
        }
    }



    /**
     * Add icon arrow
     */
    addIconArrow() {
        const iconHTML = `<span class="custom-select-arrow__line custom-select-arrow__line--left"></span><span class="custom-select-arrow__line custom-select-arrow__line--right"></span>`
        this.createDOMElement('DIV', ['custom-select-arrow'], null, iconHTML, {pos: 'beforeend', elem: this.itemSelected})
    }



    /**
     * Close current <select>
     */
    closeCurrentSelect = () => {
        this.itemSelected.classList.toggle('custom-select-container--active')
        this.optionsList.classList.add('custom-select-items--hide')
    }



    /**
     * A function that will close all select boxes in the document,
     * except the current select box
     * 
     * @param {HTMLElement or Event} elem Depends on where is called it can be .custom-select-container or Event click on document
     */
    closeAllSelect(elem) {
        let arrNo = []
        const items = document.getElementsByClassName('custom-select-items')
        const itemsLength = items.length
        const container = document.getElementsByClassName('custom-select-container')
        const containerLength = container.length

        for (let i = 0; i < containerLength; i++) {
            if (elem == container[i]) {
                arrNo.push(i)
            } else {
                container[i].classList.remove('custom-select-container--active')
            }
        }

        for (let j = 0; j < itemsLength; j++) {
            if (arrNo.indexOf(j)) {
                items[j].classList.add('custom-select-items--hide')
            }
        }
    }



    /**
     * Debug select on click
     * 
     * @param {HTMLElement} select Current queried <select> element
     */
    traceClick(select) {
        if (this.settings.debug) {
            let options = select.options
            console.log(`\n\n<select name="${select.name}" name="${select.id}">`)
            for (let i = 0; i < options.length; i++) {
                console.log(`  %c<option${(options[i].selected) ? ' selected' : ''}>${options[i].innerText}</option>`, `background: ${(options[i].selected) ? 'green' : 'transparent'}`);
            }
            console.log('</select>\n\n')
        }
    }
}

export default CustomSelect