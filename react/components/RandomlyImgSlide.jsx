class RandomlyImgSlide extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      img: path.defaultIndexImg
    };
    setInterval(this.setRandomImg, 5000);
  }

  setRandomImg = async () => {
    const data = await activityApi.getByRandom();
    await this.setState({
      img: data.img_path
    });
  };

  render() {
    return (
      <div className="random-img-slide">
        <img src={path.dbImg + this.state.img} />
      </div>
    );
  }
}
