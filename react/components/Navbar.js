class Navbar extends React.Component {
  render() {
    return (
      <div className="navbar">
        <a href={path.homePage}>
          <img src={path.logo} />
        </a>
        <a href={path.informationSystemPage}>หน้าหลักระบบสารสนเทศ</a>
      </div>
    );
  }
}
