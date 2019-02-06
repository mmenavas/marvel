import React, { Component } from 'react';
import Card from './components/Card';

class App extends Component {
  statusMessages = {
    next_card: "Good! Now pick another card.",
    not_a_match: "Tough luck! Try again.",
    match: "Very well! Find the next pair.",
    win: "Excellent! You found them all.",
    first_card: "Select a card.",
  }

  constructor() {
    super();
    this.state = {
      cards: [],
      card1: -1,
      lock: false,
      matches: 0,
      message: this.statusMessages.first_card,
      search_results: [],
      start_game: false
    }
  }

  componentDidMount() {
    let cards = [];
    drupalSettings.marvel.forEach(function (character) {
      let card = {
        id: character.id,
        image: character.thumbnail,
        isOn: false,
        isClone: false
      }
      let cloneCard = {
        ...card,
        isClone: true
      }
      cards.push(card);
      cards.push(cloneCard);
    });

    let shuffleCards = this.shuffleCards(cards);

    this.setState({
      cards: shuffleCards
    })
  }

  /**
   * Rearrange elements in array.
   * 
   * @return shuffled array
   */
  shuffleCards(cards) {
    let shuffledCards = [];
    let randomIndex = 0;

    // Shuffle cards
    while (shuffledCards.length < cards.length) {

      // Random value between 0 and cards.length - 1
      randomIndex  = Math.floor(Math.random() * cards.length);

      // If element isn't false, add element to shuffled deck
      if (cards[randomIndex]) {
        
        // Add new element to shuffle deck
        shuffledCards.push(cards[randomIndex]);

        // Set element to false to avoid being reused
        cards[randomIndex] = false;
      }
    }

    return shuffledCards;
  }

  handleCardClick(index) {
    if (this.state.lock) {
      return false;
    }

    if (this.state.cards[index].isOn) {
      return false;
    }

    let cards = [...this.state.cards];
    cards[index].isOn = true;
    
    this.setState({
      cards: cards
    });

    let code = this.play(index);
    this.setState({
      message: this.statusMessages[code]
    });

  }

  play(index) {
    // Check if first card was selected.
    if (this.state.card1 === -1) {
      this.setState({
        card1: index
      })

      return 'next_card';
    }

    // If first card wasn't selected, then it's safe to assume that the second card was.
    let cards = [...this.state.cards];
    let card1 = this.state.card1;
    let matches = this.state.matches;

    // Check if cards don't match.
    if (cards[card1].id !== cards[index].id) {
      // Lock all cards
      this.setState({
        lock: true
      }) 
      setTimeout(() => {
        cards[card1].isOn = false;
        cards[index].isOn = false;
        
        this.setState({
          card1: -1,
          cards: cards,
          lock: false 
        }) 
      }, 1000);

      return 'not_a_match';
    }

    // Selected cards are a match.
    this.setState({
      card1: -1,
      matches: matches + 1
    });

    // Check if all matching cards have been found.
    if ((matches + 1) === (cards.length / 2)) {
      return 'win';
    }

    return 'match';
  }

  render() {
    return (
      <div className="memory-game">
        <div className="status-bar">
          <p>{this.state.message}</p>
        </div>
        <ul className="cards">
          {
            this.state.cards.map((card, index) =>
              <li key={index} className="card__item">
                <Card
                  id={card.id}
                  image={card.image}
                  isOn={card.isOn}
                  reveal={e => this.handleCardClick(index)}
                />
              </li>
            )
          } 
        </ul>
        <div className="attribution">
          <p>Data provided by <a href="http://marvel.com" title="Go to Marvel's website">Marvel</a>. © 2019 Marvel</p>
        </div>
      </div>
    );
  }
}

export default App;
