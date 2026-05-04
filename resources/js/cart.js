export default class Cart {
    constructor(name) {
        this.name = name;

        if (! localStorage.getItem(this.name)) {
            this.save([]);
        }
    }

    getData() {
        return JSON.parse(localStorage.getItem(this.name)) || [];
    }

    setData(items) {
        this.save(items);
    }

    addItem(item) {
        const cartItems = this.getData();
        const existingItem = cartItems.find((cartItem) => String(cartItem.id) === String(item.id));

        if (existingItem) {
            existingItem.qty += item.qty;
            existingItem.productName = item.productName;
            existingItem.sku = item.sku;
            existingItem.price = item.price;
            existingItem.discount = item.discount;
            this.save(cartItems);
            return;
        }

        cartItems.push(item);
        this.save(cartItems);
    }

    delItem(itemId) {
        this.save(this.getData().filter((item) => String(item.id) !== String(itemId)));
    }

    decrementItem(itemId) {
        const cartItems = this.getData();
        const existingItem = cartItems.find((item) => String(item.id) === String(itemId));

        if (existingItem && existingItem.qty > 1) {
            existingItem.qty -= 1;
        }

        this.save(cartItems);
    }

    clearItem() {
        this.save([]);
    }

    clearAll() {
        localStorage.clear();
    }

    save(items) {
        localStorage.setItem(this.name, JSON.stringify(items));
    }
}
