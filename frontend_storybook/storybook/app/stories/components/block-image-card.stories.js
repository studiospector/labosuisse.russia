// Storybook API
import { storiesOf } from '@storybook/html'
import { useEffect } from '@storybook/client-api'
// Okiba API
import Component from '@okiba/component'

// Components
import renderBlock from '../../views/components/block-image-card.twig'

const dataDefault = {
    images: {
        original: '/assets/images/banner-img.jpg',
        large: '/assets/images/banner-img.jpg',
        medium: '/assets/images/banner-img.jpg',
        small: '/assets/images/banner-img.jpg'
    },
    card: {
        images: {
            original: '/assets/images/carousel-hero-img.jpg',
            large: '/assets/images/carousel-hero-img.jpg',
            medium: '/assets/images/carousel-hero-img.jpg',
            small: '/assets/images/carousel-hero-img.jpg'
        },
        infobox: {
            subtitle: 'La tecnologia dietro l’efficacia',
            paragraph: 'Grazie alla Tecnologia Transdermica (Swiss Patent CH 711 466) – ispirata alla metodologia della medicina estetica e brevettata nel 2015 – Labo supera le frontiere della scienza dermo-cosmetica divenendo la prima azienda a sviluppare una nuova tecnica di penetrazione dei principi attivi, senza iniezioni, attraverso epidermide e derma.',
            cta: {
                url: '#',
                title: 'Scopri di più',
                iconEnd: { name: 'arrow-right' },
                variants: ['quaternary']
            }
        },
        variants: ['type-7']
    }
}

storiesOf('Components|Block Image Card', module)
    .add('Default', () => renderBlock(dataDefault))