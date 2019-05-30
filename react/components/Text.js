class Text extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      text: this.props.text
    }
  }

  render() {
    return (
      <span>{this.state.text}</span>
    )
  }
}