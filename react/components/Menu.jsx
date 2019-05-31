class Menu extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isHover: false
    }
  }

  render() {
    return (
      <div className="menu-user">
        <div>Menu user</div>
        <a href="index.php">
          <RightArrow />
          <Text style="text gray" text="หน้าแรก" />
        </a>
        <a href="about.php">
          <RightArrow />
          <Text style="text gray" text="เกี่ยวกับชมรม" />
        </a>
        <a href="member.php">
          <RightArrow />
          <Text style="text gray" text="ทำเนียบชมรม" />
        </a>
        <a href="activity.php">
          <RightArrow />
          <Text style="text gray" text="โครงการและกิจกรรม" />
        </a>
        <a href="admin.php">
          <RightArrow />
          <Text style="text gray" text="การจัดการชมรม" />
        </a>
      </div>
    )
  }
}
