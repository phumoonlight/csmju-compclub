class Menu extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      isHover: false
    }
  }

  render() {
    const { index, about, members, activities, admin } = path.compclubPages
    return (
      <div className="menu-user">
        <div>Menu user</div>
        <a href={index}>
          <RightArrow />
          <Text style="text gray" text="หน้าแรก" />
        </a>
        <a href={about}>
          <RightArrow />
          <Text style="text gray" text="เกี่ยวกับชมรม" />
        </a>
        <a href={members}>
          <RightArrow />
          <Text style="text gray" text="ทำเนียบชมรม" />
        </a>
        <a href={activities}>
          <RightArrow />
          <Text style="text gray" text="โครงการและกิจกรรม" />
        </a>
        <a href={admin}>
          <RightArrow />
          <Text style="text gray" text="การจัดการชมรม" />
        </a>
      </div>
    )
  }
}
