class RightArrow extends React.Component {
  render() {
    const { style } = this.props;
    const defaultStyle = "fas fa-angle-right ";
    const additionalStyle = defaultStyle + style;
    return <i className={additionalStyle} />;
  }
}
