const cardItems = document.querySelectorAll('.card-items');
const cardViews = document.querySelectorAll('.card-views');

for(let i = 0; i < cardItems.length; i++) {
    if(cardItems[i].dataset.enabled == '1') {
        cardItems[i].classList.add('active');
        cardViews[i].style.display = 'block';
    }

    cardItems[i].addEventListener('click', e => {
        e.preventDefault();
        cardItems.forEach(cardItem => {
            cardItem.classList.remove('active');
        });
        cardItems[i].classList.add('active');
        cardViews.forEach(cardView => {
            cardView.style.display = 'none';
        });
        cardViews[i].style.display = 'block';
    });
}
