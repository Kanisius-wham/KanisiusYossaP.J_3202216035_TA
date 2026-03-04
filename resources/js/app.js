import './bootstrap';
import Alpine from 'alpinejs';

import 'swiper/css/navigation';
import 'swiper/css/pagination';
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';

window.Swiper = Swiper;



window.Alpine = Alpine;

window.cartSidebar = function() {
    return {
        open: false,
        showModal: false,
        alatAktif: null,
        jumlah: 1,
        durasi: 1,
        notif: '',
        cart: JSON.parse(localStorage.getItem('cart') || '[]'),
        grandTotal: 0,
        stokAlat: {},
        init() {
            if (typeof window.stokAlatFromBlade === 'object') {
                this.stokAlat = {...window.stokAlatFromBlade};
            }
            this.syncStokAlat();
            this.updateTotal();
        },
        syncStokAlat() {
            // Reset stok dari DB
            if (typeof window.stokAlatFromBlade === 'object') {
                this.stokAlat = {...window.stokAlatFromBlade};
            }
            // Kurangi stok untuk barang yang ada di keranjang
            this.cart.forEach(item => {
                if (this.stokAlat[item.id_alat] !== undefined) {
                    this.stokAlat[item.id_alat] -= item.jumlah;
                }
            });
        },
        getStokAvailable(id, idx) {
            id = parseInt(id);
            let totalCart = 0;
            this.cart.forEach((item, i) => {
                if (parseInt(item.id_alat) == id && i != idx) {
                    totalCart += item.jumlah;
                }
            });
            return (this.stokAlat[id] || 0) + (this.cart[idx]?.jumlah || 0) - totalCart;
        },
        updateTotal() {
            this.grandTotal = this.cart.reduce((sum, item) => sum + (item.harga * item.jumlah * (this.durasi || 1)), 0);
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },
        remove(i) {
            this.cart.splice(i, 1);
            this.syncStokAlat();
            this.updateTotal();
            this.open = true;
        },
        add(item) {
            item.id_alat = parseInt(item.id_alat);
            let exist = this.cart.findIndex(x => parseInt(x.id_alat) == item.id_alat);
            if (exist !== -1) {
                let sisa = this.stokAlat[item.id_alat];
                if (this.cart[exist].jumlah + parseInt(item.jumlah) > sisa + this.cart[exist].jumlah) return;
                this.cart[exist].jumlah += parseInt(item.jumlah);
            } else {
                if ((this.stokAlat[item.id_alat] || 0) < item.jumlah) return;
                this.cart.push({...item});
            }
            this.syncStokAlat();
            this.updateTotal();
            //this.open = true;
            this.notif = 'Alat masuk ke keranjang!';
            setTimeout(() => this.notif = '', 3000);
        }
        
    }
    
};


// Produk/Alat
const swiper = new Swiper('.mySwiper', {
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
        nextEl: '.mySwiper .swiper-button-next',
        prevEl: '.mySwiper .swiper-button-prev',
    },
    pagination: {
        el: '.mySwiper .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        900: { slidesPerView: 3 },
        600: { slidesPerView: 2 },
        0: { slidesPerView: 1 }
    }
});
// Galeri Pendakian
const swiperPendakian = new Swiper('.mySwiperPendakian', {
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
        nextEl: '.mySwiperPendakian .swiper-button-next',
        prevEl: '.mySwiperPendakian .swiper-button-prev',
    },
    pagination: {
        el: '.mySwiperPendakian .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        900: { slidesPerView: 3 },
        600: { slidesPerView: 2 },
        0: { slidesPerView: 1 }
    }
});
// Rekomendasi Wisata
const swiperWisata = new Swiper('.mySwiperWisata', {
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
        nextEl: '.mySwiperWisata .swiper-button-next',
        prevEl: '.mySwiperWisata .swiper-button-prev',
    },
    pagination: {
        el: '.mySwiperWisata .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        900: { slidesPerView: 3 },
        600: { slidesPerView: 2 },
        0: { slidesPerView: 1 }
    }
});




Alpine.start();
